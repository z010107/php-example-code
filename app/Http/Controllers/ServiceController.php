<?php
/**
 * @desc CRUD для управления сущностью "Услуга"
 *
 * @author Krasilnikov Andrey <z010107@gmail.com>
 */

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends CrudController
{

    protected $model = Service::class;

    protected $url = 'service';

    protected $listOrder = 'caption';

    protected $validationRule = [
        'id' => 'required',
        'caption' => 'required',
    ];

    protected $fields = ['caption' => ''];
}
