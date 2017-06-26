<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

class WithdrawController extends BaseController
{
    public function index(Request $request)
    {
        return view('withdraw.index');
    }

    public function create(Request $request)
    {
        return view('withdraw.create');
    }

    public function show(Request $request, $id)
    {
        return view('withdraw.show');
    }

    public function store(Request $request)
    {

    }
}
