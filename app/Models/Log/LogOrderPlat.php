<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class LogOrderPlat extends Model
{
    /**
     * 创建一条平台订单操作日志
     * @param $order_id  int 订单ID
     * @param $detail_order_id  int 子订单ID
     * @param $member int    当前操作员
     * @param $content string   操作内容
     * @param $order_state [订单状态（1:（已下单）待付款; 2:（已付款）待发货; 3:（已发货）待收货;
     *                              4:（已收货）待评价; 9:已完成;
     *                              -1:已取消; -2:已退单; -5:已退货; -9:已删除; ]
     * @param $member_id int        如果没传入 $member ，启用该操作者ID
     * @param $member_name string  如果没传入 $member ，启用该操作者名称
     * @return bool
     */
    public static function logOrderPlat($order_id,$detail_order_id, $content, $order_state,$member_id,$member_name,$site_id)
    {

        // 平台订单操作日志
        $log = LogOrderPlat::insert([
            'order_id' => $order_id,
            'detail_order_id' => $detail_order_id,
            'content' => $content,
            'create_time' => time(),
            'user_id' => $member_id,
            'user_name' => $member_name,
            'order_state' => $order_state,
            'site_id' => $site_id
        ]);

        if ($log) {
            return true;
        }

        return false;
    }
}
