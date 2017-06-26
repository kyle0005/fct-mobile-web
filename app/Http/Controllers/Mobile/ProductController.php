<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

/**产品
 * Class ProductController
 * @package App\Http\Controllers\Mobile
 */
class ProductController extends BaseController
{
    public function index(Request $request)
    {
        return view('product.index');
    }

    public function show(Request $request, $id)
    {
        return view('product.show');
    }


}
