<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

class FavoriteController extends BaseController
{
    public function index(Request $request)
    {

        return view('favorite.index');
    }

    public function store(Request $request)
    {

    }
}
