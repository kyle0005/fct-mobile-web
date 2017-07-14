<?php

/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-14
 * Time: 上午9:23
 */
namespace App\Http\Controllers\PC;



class MainController extends BaseController
{

    public function index()
    {

        return view('pc.index');
    }

}