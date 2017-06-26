<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtistCommentController extends BaseController
{
    public function index(Request $request)
    {
        return view('artist-comment.index');
    }

    public function store(Request $request)
    {
    }
}
