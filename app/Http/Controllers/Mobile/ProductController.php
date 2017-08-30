<?php

namespace App\Http\Controllers\Mobile;

use App\Artist;
use App\Exceptions\BusinessException;
use App\Member;
use App\Product;
use App\OrderComment;
use App\ProductCategory;
use App\ProductMaterial;
use Illuminate\Http\Request;

/**宝贝
 * Class ProductController
 * @package App\Http\Controllers\Mobile
 */
class ProductController extends BaseController
{

    /**宝贝详情
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        try
        {
            $result = Product::getProduct($id);
            if ($result)
                Product::addVisitCount($id);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage());
        }

        if (!$result) return $this->autoReturn('没有找到此产品内容');

        //处理content图片延迟加载
/*        $result->content = str_replace(
            'src="', 'src="'.fct_cdn('/images/img_loader_s.gif').'" v-view="',
            $result->content);*/

        $shareUrl = url('products/'. $id);
        $shopId = intval($request->get(env('SHARE_SHOP_ID_KEY')));
        if ($shopId > 0) {
            $this->setShopId();
            $shareUrl = $shareUrl . '?'.env('SHARE_SHOP_ID_KEY').'=' .$shopId;
        }

        $member = Member::getAuth();
        $chatDatas = [
            "name" => $member ? $member->userName : "",
            "tel" => $member ? $member->cellPhone : "",
            "comment" => $result->name . '--' . url('product/' . $result->id) . '"}',
        ];

        return view('product.show', [
            'title' => fct_title($result->name),
            'categories' => ProductCategory::getCategories(),
            'product' => $result,
            'chat_url' => 'https://static.meiqia.com/dist/standalone.html?_=t&eid=62925&clientid='
                . ($member ? $member->memberId : "")
                . '&metadata=' .urlencode(json_encode($chatDatas, JSON_UNESCAPED_UNICODE)),
            'share' => [
                'title' => '发现一个宝贝 - '. $result->name,
                'link' => $shareUrl,
                'img' => $result->defaultImage,
                'desc' => $result->intro,
            ]
        ]);
    }

    public function getProductComments(Request $request, $product_id)
    {
        $pageIndex = $request->get('page', 1);

        try
        {
            $result = OrderComment::getComments($product_id, $pageIndex);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage());
        }

        return $this->returnAjaxSuccess("获取评论列表成功", null, $result);
    }

    public function getProductArtists(Request $request, $product_id)
    {
        $ids = $request->get('ids', '');
        try
        {
            $result = Artist::getArtistByIds($ids, $product_id);
            return $this->returnAjaxSuccess('获取宝贝艺术家列表成功', null, $result);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage());
        }
    }

    public function getProductaMaterials(Request $request, $product_id)
    {
        $materialIds = $request->get('ids');
        try
        {
            $result = ProductMaterial::getMaterialsByIds($materialIds, $product_id);

            return $this->returnAjaxSuccess('获取宝贝泥料列表成功', null, $result);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage());
        }
    }
}
