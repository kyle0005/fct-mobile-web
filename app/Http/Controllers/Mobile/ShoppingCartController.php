<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

/**购物车
 * Class ShoppingCartController
 * @package App\Http\Controllers\Mobile
 */
class ShoppingCartController extends BaseController
{
    public function index(Request $request)
    {
        return view('cart.index');
    }

    public function store(Request $request)
    {

    }

    public function setDelete(Request $request, $id)
    {

    }
}
