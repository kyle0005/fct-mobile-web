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
            'title' => fct_title(),
            'hasNewVisitor' => $this->hasNewVisitor(),
            'entity' => $result,
            'share' => [
                'title' => '方寸堂 - 不只不同',
                'link' => $this->myShareUrl(url('/', [], env('APP_SECURE'))),
                'img' => fct_cdn('/img/mobile/share_logo.png', true),
                'desc' => '汇聚东方美学匠心之作的紫砂交流电商平台。',
            ],
        ]);
    }
}