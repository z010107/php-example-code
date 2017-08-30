<?php
/**
 * @desc Контроллер для главной страницы и рассчета скидки
 *
 * @author Krasilnikov Andrey <z010107@gmail.com>
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Service;
use App\Discount;
use Validator;
use Session;

class MainController extends Controller
{
    protected $data = [];

    /**
     * @desc Отображение формы проверка наличия скидки
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['services'] = Service::orderBy('caption', 'asc')->get();
        return view('main', $this->data);
    }

    /**
     * @desc Рассчет и отображение представленной скидки
     *
     * @param Request $request
     * @return mixed
     */
    public function checkDiscount(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'fio' => 'required',
                'birthday' => 'required',
            ];
            if (!empty($request->gender)) {
                $rules['gender'] = 'in:female,male';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['result' => false, 'message' => implode("<br/>", $validator->errors()->all())]);
            }

            $services = !empty($request->services) ? array_filter($request->services) : [];
            $birthday = implode("-", array_reverse(explode(".", $request->birthday)));
            $phone = $request->phone;
            $gender = $request->gender;

            $today = date("Y-m-d");

            $discounRes = Discount::where('start_on', '<=', $today)
                ->where(function ($query) use ($today) {
                    $query->where('end_on', '>=', $today)
                        ->orWhereNull('end_on');
                });

            if (!empty($services)) {
                foreach ($services as $k => $s) {
                    $discounRes->leftJoin('discount_service_links as t' . $k, function ($join) use ($k, $s) {
                        $join
                            ->on('t' . $k . '.discount_id', '=', 'discounts.id')
                            ->where('t' . $k . '.service_id', '=', $s);
                    })->whereNotNull('t' . $k . '.id');
                }
            } else {
                $discounRes->leftJoin('discount_service_links as t0', 't0.discount_id', '=', 'discounts.id')->whereNull('t0.id');
            }

            if (!empty($birthday)) {
                $bdTs = strtotime($birthday);
                $bdBeforeWeekTs = time() - 86400 * 7;
                $bdAfterWeekTs = time() + 86400 * 7;

                if ($bdTs > $bdBeforeWeekTs && $bdTs < $bdAfterWeekTs) {
                    $discounRes->where(function ($query) {
                        $query->where(function ($subquery) {
                            $subquery->where('bd_week_before', '=', true)
                                ->orWhere('bd_week_before', '=', false);
                        });
                        $query->where(function ($subquery) {
                            $subquery->where('bd_week_after', '=', true)
                                ->orWhere('bd_week_after', '=', false);
                        });
                    });
                } else {
                    $discounRes->where('bd_week_before', '=', false);
                    $discounRes->where('bd_week_after', '=', false);
                }
            } else {
                $discounRes->where('bd_week_before', '=', false);
                $discounRes->where('bd_week_after', '=', false);
            }

            if (!empty($phone)) {
                $discounRes->where(function ($query) use ($phone) {
                    $query->where('exist_phone', '=', true)
                        ->orWhere('phone_last_digit', '=', substr($phone, -4));
                });
            } else {
                $discounRes->where(function ($query) use ($phone) {
                    $query->where('exist_phone', '=', false)
                        ->where('phone_last_digit', '=', '');
                });
            }

            if (!empty($gender)) {
                $discounRes->where('gender', '=', $gender);
            } else {
                $discounRes->whereNull('gender');
            }

            $discount = $discounRes->orderBy('discount', 'desc')->first();

            return response()->json(['result' => (bool)$discount, 'message' => $discount ?
                    'Вам предоставлена скидка ' . number_format($discount->discount, 0, '.', ' ') . '%' :
                    'Для Вас не найдена скидка! Попробуйте еще :)']);
        } else {
            return redirect('');
        }
    }
}