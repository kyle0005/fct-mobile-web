<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午10:09
 */

namespace App\Http\Controllers\Mobile;


use App\AllianceStore;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class AllianceStoreController extends BaseController
{
    public function index(Request $request)
    {
        try
        {
            $result = AllianceStore::find();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('alliance.store.index', [
            'title' => fct_title("联盟成员列表"),
            'entities' => $result,
        ]);
    }

}