<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-17
 * Time: 上午10:48
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\Upload;
use Illuminate\Http\Request;

class UploadController extends BaseController
{

    public function image(Request $request)
    {

        if ($request->getMethod() == 'POST') {
            $action = "";//$request->get('action');
            $file = $request->file('file');
            if (!$file)
            {
                return $this->autoReturn('上传文件不存在');
            }
            if ($file->getSize() < 1) {

                return $this->autoReturn('上传文件不存在');
            }

            try
            {

                $result = Upload::uploadImage($action, $file);
                return $result;
            }
            catch (BusinessException $e)
            {
                return $this->autoReturn($e->getMessage());
            }
        }

        return $this->autoReturn("只支持POST提交");
    }
}