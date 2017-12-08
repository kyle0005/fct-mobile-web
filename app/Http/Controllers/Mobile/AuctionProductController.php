<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-11-28
 * Time: 下午2:03
 */

namespace App\Http\Controllers\Mobile;


use App\AuctionProduct;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class AuctionProductController extends BaseController
{

    public function index(Request $request) {

        $name = $request->get('name', '');
        $categoryId = $request->get('category_id', '');
        $artistId = $request->get('artist_id', '');
        $status = $request->get('status', '');
        $page = $request->get('page', 1);
        try
        {
            $result = AuctionProduct::getProducts($name, $categoryId, $artistId, $status, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        return view('auction.product.index', [
            'products' => $result,
            'title' => fct_title('拍卖'),
            'share' => [
                'title' => fct_title('方寸拍卖—小步走，慢慢来！'),
                'link' => $this->myShareUrl(url('auctions', [], env('APP_SECURE'))),
                'img' => fct_cdn('/img/mobile/pm-logo.png'),
                'desc' => '方寸拍卖—小步走，慢慢来！',
            ]
        ]);
    }

    public function show(Request $request, $id)
    {
        if ($id < 1) {
            return $this->autoReturn('拍品ID不存在', 404);
        }

        try
        {
            $result = AuctionProduct::getProduct($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        //把聊天提取出来
        $chatList = $result ? $result->chatList : [];
        unset($result->chatList);

        //ajax请求
        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        $shareTitle = '拍品“' . $result->name . '”';
        if ($result->status == 1)
            $shareTitle .= '即将开拍…';
        elseif ($result->status == 4)
            $shareTitle .= '拍卖已结束…';
        else
            $shareTitle .= '正在拍卖中…';
        //wegsocket传入token
        $member = $this->memberLogged(false);
        $result->token = $member ? $member->token : '';

        return view('auction.product.show', [
            'title' => fct_title($result->name .'拍卖'),
            'entity' => $result,
            'chatList' => $chatList,
            'share' => [
                'title' => $shareTitle,
                'link' => $this->myShareUrl(url('auctions', [], env('APP_SECURE'))),
                'img' => fct_cdn('/img/mobile/pm-logo.png'),
                'desc' => $result->intro,
            ]
        ]);
    }
}