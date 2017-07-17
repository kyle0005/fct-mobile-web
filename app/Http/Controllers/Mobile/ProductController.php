<?php

namespace App\Http\Controllers\Mobile;

use App\Artist;
use App\Exceptions\BusinessException;
use App\Product;
use App\OrderComment;
use App\ProductMaterial;
use Illuminate\Http\Request;

/**产品
 * Class ProductController
 * @package App\Http\Controllers\Mobile
 */
class ProductController extends BaseController
{

    /**产品详情
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

        return view('product.show', $result);
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
            return $this->returnAjaxSuccess('获取产品艺术家列表成功', null, $result);
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

            return $this->returnAjaxSuccess('获取产品泥料列表成功', null, $result);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage());
        }
    }

}
