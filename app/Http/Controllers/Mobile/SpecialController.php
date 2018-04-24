<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午9:51
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\Special;
use Illuminate\Http\Request;

class SpecialController extends BaseController
{

    public function home(Request $request)
    {
        try
        {
            $result = Special::getHome();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('special.home', [
            'title' => fct_title('方寸堂'),
            'entity' => $result,
        ]);
    }
}