<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

/**充值
 * Class RechargeController
 * @package App\Http\Controllers\Mobile
 */
class RechargeController extends BaseController
{
    public function index(Request $request)
    {
        return view('recharge.index');
    }

    public function create(Request $request)
    {
        return view('recharge.create');
    }

    public static function store(Request $request)
    {

    }
}
