<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

class ProductCommentController extends BaseController
{
    public function index(Request $request)
    {
        return view('product-comment.index');
    }

    public function store(Request $request)
    {
    }
}
