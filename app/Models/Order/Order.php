<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:37
 */

namespace App\Models\Order;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function addOrder($data)
    {
        return self::insert($data);
    }

}