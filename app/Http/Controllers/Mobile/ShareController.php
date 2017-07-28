<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;

class ShareController extends BaseController
{
    public function index(Request $request)
    {
        $code = $request->get('code', '');
        $name = $request->get('name', '');
        $sortIndex = intval($request->get('sort', 0));
        $page = intval($request->get('page', 1));

        try
        {

            $result = Product::getShareProducts($code, $name, $sortIndex, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess('获取成功', null, $result);

        return view('share.index', [
            'title' => '分享',
            'categories' => ProductCategory::getCategories(),
            'entries' => $result,
        ]);
    }
}
