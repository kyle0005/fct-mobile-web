<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends BaseController
{
    public function index(Request $request)
    {
        $fromType = intval($request->get('from_type', 0));

        try
        {
            $result = Favorite::getFavorites($fromType);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess('', null, $result);

        return view('favorite.index', [
            'title' => '收藏列表',
            'entries' => $result,
        ]);
    }

    public function store(Request $request)
    {
        $fromType = strval($request->get('from_type', ""));
        $fromId = intval($request->get('from_id', 0));

        if ($fromId < 1)
        {
            return $this->returnAjaxError('收藏来源错误');
        }

        if ($fromType != '0' && !$fromType)
        {
            return $this->returnAjaxError('收藏来源错误');
        }

        try
        {
            $result = Favorite::saveFavorite(intval($fromType), $fromId);
            return $this->returnAjaxSuccess(($result->data ? '添加' : '取消') . "收藏成功", null, ['favoriteState' => $result->data]);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }
}
