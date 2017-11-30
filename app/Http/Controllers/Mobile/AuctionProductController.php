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

        $result->title = fct_title('拍卖');

        return view('auction.product.index', $result);
    }

    public function show(Request $request, $id)
    {

        try
        {
            $result = AuctionProduct::getProduct($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('auction.product.show', [
            'title' => fct_title('售后详情'),
            'entity' => $result,
        ]);
    }
}