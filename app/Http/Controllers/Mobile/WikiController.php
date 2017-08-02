<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-11
 * Time: 下午3:14
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\Wiki;
use Illuminate\Http\Request;

class WikiController extends BaseController
{

    public function index(Request $request)
    {
        try
        {
            $result = Wiki::getHome();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        $shareUrl = url('wiki');
        $shopId = intval($request->get(env('SHARE_SHOP_ID_KEY')));
        if ($shopId > 0) {
            $this->setShopId();
            $shareUrl = $shareUrl . '?'.env('SHARE_SHOP_ID_KEY').'=' .$shopId;
        }

        $result['share'] = [
            'title' => $result['title'],
            'link' => $shareUrl,
            'img' => 'http://test.fangcuntang.com/images/logo.png',
            'desc' => '紫砂',
        ];
        return view('wiki.index', $result);
    }

    public function show(Request $request)
    {

        $typeId = intval($request->get('from_id', 0));
        $type = $request->get('from_type', '');

        try
        {
            $result = Wiki::getItem($typeId, $type);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        $shareUrl = url('wiki');
        $shopId = intval($request->get(env('SHARE_SHOP_ID_KEY')));
        if ($shopId > 0) {
            $this->setShopId();
            $shareUrl = $shareUrl . '?'.env('SHARE_SHOP_ID_KEY').'=' .$shopId;
        }

        $result['share'] = [
            'title' => $result['title'],
            'link' => $shareUrl,
            'img' => 'http://test.fangcuntang.com/images/logo.png',
            'desc' => '紫砂',
        ];

        return view('wiki.show', $result);
    }

}