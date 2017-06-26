<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

/**支付
 * Class PayController
 * @package App\Http\Controllers\Mobile
 */
class PayController extends BaseController
{
    public function index()
    {

        return view('pay.index');
    }

    public function store()
    {

    }
}
