<?php
/**
 * @desc Основной клас для CRUD контроллеров
 *
 * @author Krasilnikov Andrey <z010107@gmail.com>
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Service;
use Validator;
use Session;

class CrudController extends Controller
{
    protected $data = [];

    protected $model;
    protected $url;
    protected $listOrder;

    protected $validationRule = [];
    protected $fields = [];

    protected function getModel()
    {
        return $this->model;
    }

    /**
     * @desc Отображение списка сущностей
     *
     * @return mixed
     */
    public function index()
    {
        $model = $this->getModel();
        $this->data['objs'] = $model::orderBy($this->listOrder, 'asc')->get();

        return view($this->url . '/index', $this->data);
    }

    /**
     * @desc Отображение формы создания сущности
     *
     * @return mixed
     */
    public function add()
    {
        return view($this->url . '/add', $this->data);
    }

    /**
     * @desc Добавление или обновление сущности
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRule);

        $id = intval($request->id);

        if ($validator->fails()) {
            $this->data['validation_error'] = true;
            return redirect($this->url . '/' . ($id ? 'edit/' . $id : 'add'))
                ->withErrors($validator)
                ->withInput();
        }

        $model = $this->getModel();

        if ($id) {
            $this->data['obj'] = $model::findOrFail($id);
        } else {
            $this->data['obj'] = new $model();
        }

        foreach ($this->fields as $f => $v) {
            if (isset($request->$f)) {
                $this->data['obj']->$f = $v !== '' && empty($request->$f) ? $v : $request->$f;
            }
        }
        $this->data['obj']->save();

        Session::flash('flash_message', trans('crud.' . $this->url . '_' . ($id ? 'update' : 'add')));
        return redirect($this->url);
    }

    /**
     * @desc Отображение формы редактирования сущности
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $model = $this->getModel();
        $this->data['obj'] = $model::findOrFail($id);

        return view($this->url . '/edit', $this->data);
    }

    /**
     * @desc Удаление сущности
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $model = $this->getModel();
        $obj = $model::findOrFail($id);
        $obj->delete();

        Session::flash('flash_message', trans('crud.' . $this->url . '_delete'));
        return redirect($this->url);
    }
}
