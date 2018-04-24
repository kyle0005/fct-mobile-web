<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午10:06
 */

namespace App\Http\Controllers\Mobile;


use App\Alliance;
use App\Exceptions\BusinessException;

class AllianceController extends BaseController
{

    public function index()
    {
        try
        {
            $result = Alliance::getAlliance();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('alliance.index', [
            'title' => fct_title('我的联盟'),
            'entity' => $result,
        ]);
    }
}