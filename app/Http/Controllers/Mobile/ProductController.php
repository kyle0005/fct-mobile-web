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
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage());
        }

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

        $title = (isset($result->name) && $result->name ? $result->name : '宝贝详情');

        return view('product.show', [
            'title' => fct_title($title),
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

        try
        {
            $result = Artist::getArtistsByProductId($product_id);
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
        $materialIds = $request->get('material_ids');
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
