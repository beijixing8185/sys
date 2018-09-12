<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 16:52
 */

namespace App\Controllers\V1\Common;


use App\Facades\SysApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class UploadController extends Controller
{

    // 文件上传方法
    public function upload(Request $request)
    {
            $file = $request->file('images');

            // 文件是否上传成功
            if ($file->isValid()) {
                $type = $file->getClientMimeType();     // image/jpeg
                $arr_type = array("jpg", "jpeg", "png", "gif");
                if(!in_array($type, $arr_type)) return SysApi::apiResponse(431,'图片格式不被支持');
                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径


                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                var_dump($bool);
                return $filename;
            }

    }

}