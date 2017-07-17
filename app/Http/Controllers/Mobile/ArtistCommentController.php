<?php

namespace App\Http\Controllers\Mobile;

use App\ArtistComment;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtistCommentController extends BaseController
{
    public function index(Request $request, $artist_id)
    {
        $pageIndex = $request->get('page', 1);

        try
        {
            $result = ArtistComment::getComments($artist_id, $pageIndex);
            return $this->returnAjaxSuccess("获取评论列表成功", null, $result);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function store(Request $request, $artist_id)
    {
        $content = $request->get('content');

        try
        {
            ArtistComment::saveComment($artist_id, $content);
            return $this->returnAjaxSuccess("评论成功");
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function getArtistProducts(Request $request, $product_id)
    {

        try
        {
            $result = Artist::getArtistsByProductId($product_id);
            return $this->returnAjaxSuccess('获取产品艺术家列表成功', null, $result);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage());
        }
    }
}
