<?php

namespace App\Http\Controllers\Mobile;

use App\Product;
use App\ProductComment;
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
        $result = Product::getProduct($id);

        return view('product.show', $result);
    }

    public function getProductComments(Request $request, $product_id)
    {
        $pageIndex = $request->get('page', 1);

        $result = ProductComment::getComments($product_id, $pageIndex);

        return $this->returnAjaxSuccess("获取评论列表成功", null, $result);
    }

    public function getProductArtists(Request $request, $product_id)
    {
        return view('product.artist-index');
    }

    public function getProductaMaterials(Request $request, $product_id)
    {
        return view('product.material-index');
    }

}
