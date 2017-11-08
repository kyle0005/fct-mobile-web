<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-10
 * Time: 下午2:11
 */

namespace App\Http\Controllers\Mobile;


use App\ArtistDynamic;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class ArtistDynamicController extends BaseController
{
    public function index(Request $request, $artist_id)
    {
        $pageIndex = $request->get('page', 1);

        try
        {
            $result = ArtistDynamic::getDynamics($artist_id, $pageIndex);
            return $this->returnAjaxSuccess("获取动态列表成功", null, $result);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }
}