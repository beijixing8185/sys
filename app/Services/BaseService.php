<?php

namespace App\Services;

class BaseService implements ServiceCode
{
    /**
     * 定义统一的 Service 返回值格式
     *
     * @param int $code 返回码，code = 0 表示成功
     * @param string $data 返回数据
     * @param string $message code != 0 时的返回信息
     *
     * @return array
     * @author yangrui
     */
    public function sameReturn($code = 0, $data = '', $message = '')
    {
        return [
            'code'    => $code,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * 返回图片类型的字符串说明
     *
     * @param int $num_type 通过 getimagesize() 方法获取的图片类型说明
     *
     * @return string|null
     * @author yangrui
     */
    public function getImgStringTypeByNumType($num_type)
    {
        $type_str_arr = [1 => 'gif', 2 => 'jpeg', 3 => 'png'];

        return isset($type_str_arr[$num_type]) ? $type_str_arr[$num_type] : null;
    }

    /**
     * 通过url保存文件到本地
     * 为了解决 file_get_contents 从服务器获取文件内容慢的情况
     *
     * @param string $url 文件URL
     * @param string $filename 保存文件路径（全路径）
     *
     * @return bool
     * @author yangrui
     */
    public function saveImageByUrl($url, $filename)
    {
        $ch = curl_init();
        $fp = fopen($filename, 'wb');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $res = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $res;
    }

    /**
     * 生成缩略图
     *
     * @param $resource
     * @param $src_w
     * @param $src_h
     * @param $img_type_str
     * @param null $width 缩略图宽度（只指定高度时进行等比缩放）
     * @param null $height 缩略图高度（只指定宽度时进行等比缩放）
     * @param null $filename
     *
     * @return bool|resource
     */
    public function makeThumbnail($resource, $src_w, $src_h, $img_type_str, $width = null, $height = null, $filename = null)
    {
        // 图片宽高都没指定
        if (!isset($width) && !isset($height)) {
            return false;
        }

        if (isset($width) && $width <= 0) {
            return false;
        }

        if (isset($height) && $height <= 0) {
            return false;
        }

        if (!isset($width)) {
            $width = $src_w * ($height / $src_h);
        }

        if (!isset($height)) {
            $height = $src_h * ($width / $src_w);
        }

        //  新建一个真彩色图像（画布）
        $result_img = imagecreatetruecolor($width, $height);

        // 重采样拷贝部分图像并调整大小
        imagecopyresampled($result_img, $resource, 0, 0, 0, 0, $width, $height, $src_w, $src_h);

        // 释放内存（图片资源）
        imagedestroy($resource);

        // 如果文件路径不为空，就将图片保存到文件，并释放资源
        if (isset($filename)) {
            $imagefunc = 'image' . $img_type_str;
            $bol = $imagefunc($result_img, $filename);
            imagedestroy($result_img);
            return $bol;
        }

        return $result_img;
    }

    /**
     * 生成圆形图片
     *
     * @param string $src 待处理图片路径（全路径）或 url
     * @param null $filename
     *
     * @return bool
     * @author yangrui
     */
    public function makeCircleImg($src, $filename = null)
    {
        // 取得图像大小
        $size = getimagesize($src);

        if (!$size) {
            return false;
        }

        list($src_w, $src_h, $src_type) = $size;
        $img_type = $this->getImgStringTypeByNumType($src_type);

        // 读取待处理的图片（原图片）
        $imagecreatefunc = 'imagecreatefrom' . $img_type;
        $src_img_resource = $imagecreatefunc($src);

        // 如果图片不是正方形就取最小边作为圆半径，从左边开始剪切成圆形
        $src_w = $src_h = min($src_w, $src_h);
        $img = imagecreatetruecolor($src_w, $src_h);

        // 设置标记以在保存 PNG 图像时保存完整的 alpha 通道信息（与单一透明色相反），为了设置圆以外为透明色
        imagesavealpha($img, true);

        // 拾取一个完全透明的颜色，最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $bg);

        // 定义圆的半径，填充生成圆形
        $r = $src_w / 2;
        for ($x = 0; $x < $src_w; $x++) {
            for ($y = 0; $y < $src_h; $y++) {
                $rgbColor = imagecolorat($src_img_resource, $x, $y);
                if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
            }
        }

        // 输出图片
        $imagefunc = 'image' . $img_type;
        if ($filename) {
            $imagefunc($img, $filename);
        } else {
            header('Content-Type: ' . $size['mime']);
            $imagefunc($img);
        }

        // 释放内存（图片资源）
        imagedestroy($src_img_resource);
        imagedestroy($img);

        return true;
    }

    /**
     * 图片圆角制作
     *
     * @param $resource
     * @param $width
     * @param $height
     * @param float $radius_percent
     *
     * @return resource
     */
    public function makeRadiusImg($resource, $width, $height, $radius_percent = 0.25)
    {
        $new_resource = imagecreatetruecolor($width, $height);

        $radius = 0;
        if (isset($width)) {
            $radius = intval($width * $radius_percent);
        }

        if (!$radius) {
            $radius = intval($height * $radius_percent);
        }

        // 关闭混合模式，以便透明颜色能覆盖原画布
        imagealphablending($new_resource, false);

        // 设置保存PNG时保留透明通道信息（保存为PNG格式的时候才有效，现在只提供该方法）
        imagesavealpha($new_resource, true);

        // 拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($new_resource, 255, 255, 255, 127);

        imagefill($new_resource, 0, 0, $bg);

        $r = $radius; // 圆 角半径
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgbColor = imagecolorat($resource, $x, $y);
                if (($x >= $radius && $x <= ($width - $radius)) || ($y >= $radius && $y <= ($height - $radius))) {
                    //不在四角的范围内,直接画
                    imagesetpixel($new_resource, $x, $y, $rgbColor);
                } else {
                    //在四角的范围内选择画
                    //上左
                    $y_x = $r; //圆心X坐标
                    $y_y = $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($new_resource, $x, $y, $rgbColor);
                    }
                    //上右
                    $y_x = $width - $r; //圆心X坐标
                    $y_y = $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($new_resource, $x, $y, $rgbColor);
                    }
                    //下左
                    $y_x = $r; //圆心X坐标
                    $y_y = $height - $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($new_resource, $x, $y, $rgbColor);
                    }
                    //下右
                    $y_x = $width - $r; //圆心X坐标
                    $y_y = $height - $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($new_resource, $x, $y, $rgbColor);
                    }
                }
            }
        }

        imagedestroy($resource);
        return $new_resource;
    }

    /**
     * 给图片添加文字内容
     *
     * @param string $src 图片路径
     * @param string $text 文字内容
     * @param int $font_size 字体大小
     * @param string $font_file 字体文件
     * @param int $angle 字体旋转角度（写入方向）
     * @param int $x_position 位置（x方向）
     * @param int $y_position 位置（y方向）
     * @param null $filename 文件保存位置，为空时，输出浏览器
     *
     * @return bool
     * @author yangrui
     */
    public function writeTextToImage($src, $text, $x_position = 0, $y_position = 0, $font_size = 20, $font_file = '', $angle = 0, $filename = null)
    {
        // 取得图像大小
        $size = getimagesize($src);

        if (!$size) {
            return false;
        }

        $img_type = $this->getImgStringTypeByNumType($size[2]);

        // 加载要写入文字的图片（原图片）
        $imagecreatefunc = 'imagecreatefrom' . $img_type;
        $src_img_resource = $imagecreatefunc($src);

        // 定义颜色
        $black = imagecolorallocate($src_img_resource, 0, 0, 0);

        if (!file_exists($font_file)) {
            $font_file = public_path('fonts/YaHei.ttf');
        }

        imagettftext($src_img_resource, $font_size, $angle, $x_position, $y_position, $black, $font_file, $text);

        // 输出图形
        $imagefunc = 'image' . $img_type;
        if ($filename) {
            $imagefunc($src_img_resource, $filename);
        } else {
            header('Content-Type: ' . $size['mime']);
            $imagefunc($src_img_resource);
        }

        ImageDestroy($src_img_resource);

        return true;
    }

    /**
     * 把传入的金额，去除微信手续费，如果 $is_minus_taxes = true，再去除税费
     *
     * @param string $total 金额
     * @param bool $is_subtract_taxes 是否扣除税
     *
     * @return string
     */
    public function subtractCharge($total, $is_subtract_taxes = true)
    {
        // 减去微信手续费
        $wx_service_charge_ratio = config('ynmo.wx_service_charge_ratio');
        $total = bcmul($total, bcsub(1, $wx_service_charge_ratio, 3), 2);

        // 是否减税
        if ($is_subtract_taxes) {
            $tax_rate = config('ynmo.tax_rate');
            $total = bcmul($total, bcsub(1, $tax_rate, 4), 2);
        }

        return $total;
    }

    /**
     * 用户使用指定结算价格结算商品时，应返还的佣金数
     *
     * @param $price_arr
     * @param $settlement_price
     *
     * @return null
     */
    public function getReturnYesb($price_arr, $settlement_price)
    {
        $return_arr = null;

        foreach ($price_arr as $item) {
            if (bccomp($settlement_price, $item['price'], 2) == 0) {
                $return_arr = $item;
                break;
            }
        }

        return $return_arr;
    }


}