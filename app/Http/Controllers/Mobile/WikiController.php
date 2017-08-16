<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-11
 * Time: 下午3:14
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\ProductCategory;
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

        $result['title'] = fct_title('百科');
        $result['categories'] = ProductCategory::getCategories();
        $result['share'] = [
            'title' => fct_title('百科'),
            'link' => $shareUrl,
            'img' => 'http://cdn.fangcun.com/static/img/fc_logo.png',
            'desc' => '方寸堂百科，专注于紫砂领域知识的创建与分享。',
        ];

        return view('wiki.index', $result);
    }

    public function show(Request $request)
    {

        $typeId = intval($request->get('from_id', 0));
        $type = $request->get('from_type', '');

        try {
            $result = Wiki::getItem($typeId, $type);
        } catch (BusinessException $e) {
            return $this->autoReturn($e->getMessage());
        }

        $shareUrl = url('wiki');
        $shopId = intval($request->get(env('SHARE_SHOP_ID_KEY')));
        if ($shopId > 0) {
            $this->setShopId();
            $shareUrl = $shareUrl . '?' . env('SHARE_SHOP_ID_KEY') . '=' . $shopId;
        }

        return view('wiki.show', [
            'title' => fct_title($result->name),
            'categories' => ProductCategory::getCategories(),
            'entry' => $result,
            'share' => [
                'title' => fct_title($result->name),
                'link' => $shareUrl,
                'img' => $result->image,
                'desc' => $result->intro,
            ]
        ]);
    }

}