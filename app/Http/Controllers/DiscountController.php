<?php
/**
 * @desc CRUD для управления сущностью "Условие предоставления скидки"
 *
 * @author Krasilnikov Andrey <z010107@gmail.com>
 */

namespace App\Http\Controllers;

use App\Discount;
use App\Service;
use App\DiscountServiceLink;
use Illuminate\Http\Request;

class DiscountController extends CrudController
{
    protected $model = Discount::class;

    protected $url = 'discount';

    protected $listOrder = 'id';

    protected $validationRule = [
        'id' => 'required',
        'start_on' => 'required',
        'discount' => 'required',
    ];

    protected $fields = [
        'bd_week_before' => '',
        'bd_week_after' => '',
        'exist_phone' => '',
        'phone_last_digit' => '',
        'gender' => null,
        'start_on' => '',
        'end_on' => null,
        'discount' => '',
    ];

    /**
     * @desc Отображение формы создания сущности
     *
     * @return mixed
     */
    public function add()
    {
        $this->data['services'] = Service::orderBy('caption', 'asc')->get();
        return parent::add();
    }

    /**
     * @desc Отображение формы редактирования сущности
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $this->data['services'] = Service::orderBy('caption', 'asc')->get();
        $this->data['links'] = iterator_to_array(DiscountServiceLink::where('discount_id', $id)->pluck('service_id'));
        return parent::edit($id);
    }

    /**
     * @desc Добавление или обновление сущности и обнвление связей сущности "Условие предоставления скидки" с сущностью "Услуга"
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        // Приведение в db-friendly формат даты
        foreach(['start_on', 'end_on'] as $f) {
            if (!empty($request->$f)) {
                $request->$f = implode("-", array_reverse(explode(".", $request->$f)));
            }
        }

        $p = parent::store($request);

        if (isset($this->data['validation_error'])) {
            return $p;
        }

        // Установка связей дисконт->услуги
        DiscountServiceLink::where('discount_id', $this->data['obj']->id)->delete();
        if (!empty($request->services)) {
            $insertData = [] ;
            foreach($request->services as $serviceId) {
                $insertData[] = [
                    'discount_id' => $this->data['obj']->id,
                    'service_id' => $serviceId
                ];
            }
            DiscountServiceLink::insert($insertData);
        }

        return $p;
    }
}
