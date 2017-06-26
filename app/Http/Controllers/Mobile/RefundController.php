<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

class RefundController extends BaseController
{
    public function index(Request $request)
    {
        return view('refund.index');
    }

    public function create(Request $request)
    {
        return view('refund.create');
    }

    public function show(Request $request, $id)
    {
        return view('refund.show');
    }

    public function store(Request $request)
    {

    }
}
