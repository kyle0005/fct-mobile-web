<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

class ShareController extends BaseController
{
    public function index(Request $request)
    {
        return view('share.index');
    }

    public function show(Request $request, $id)
    {
        return view('share.show');
    }
}
