<?php

namespace App\Http\Controllers\Mobile;

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
        return view('product.show');
    }

}
