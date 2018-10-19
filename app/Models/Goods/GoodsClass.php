<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 15:54
 */

namespace App\Models\Goods;


use Illuminate\Database\Eloquent\Model;

class GoodsClass extends Model
{

    /**
     * 获取分类列表
     * @param $id
     * @return mixed
     */
    public static function getClassList($id,$where='')
    {
        return self::whereRaw('pid = '.$id.$where)->orderBy('sort','ASC')->get();
    }
}