<?php
/**
 * @desc Модель сущности "Условие предоставления скидки"
 *
 * @author Krasilnikov Andrey <z010107@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    /**
     * @desc Связанные ссылки на эту сущность
     *
     * @return mixed
     */
    public function links()
    {
        return $this->hasMany('App\DiscountServiceLink', 'discount_id', 'id');
    }


}
