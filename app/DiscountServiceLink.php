<?php
/**
 * @desc Модель связей сущности "Условие предоставления скидки" и сущности "Услуги"
 *
 * @author Krasilnikov Andrey <z010107@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountServiceLink extends Model
{
    public function discount()
    {
        return $this->belongsTo('App\Discount', 'discount_id');
    }

    public function Service()
    {
        return $this->hasOne('App\Service', 'id', 'service_id');
    }
}
