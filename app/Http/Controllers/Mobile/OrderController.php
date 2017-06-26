<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

/**订单
 * Class OrderController
 * @package App\Http\Controllers\Mobile
 */
class OrderController  extends BaseController
{
    public function index(Request $request)
    {
        return view('order.index');
    }

    public function show(Request $request, $id)
    {
        return view('order.show');
    }

    public function checkout(Request $request)
    {

        return view('order.checkount');
    }

    public function store(Request $request)
    {

    }
}
