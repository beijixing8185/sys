<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 14:40
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class AdminSite extends Model
{
    protected $connection = 'sysSrv';

    protected $table = 'syssrv_admin_sites';

    public static function getAdmin($id)
    {
        return self::find($id);
    }
}