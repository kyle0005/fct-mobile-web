<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

class SettlementController extends BaseController
{
    public function index(Request $request)
    {
        return view('settlement.index');
    }
    
    public function show(Request $request, $id)
    {
        return view('settlement.show');
    }
}
