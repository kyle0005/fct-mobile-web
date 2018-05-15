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
        if (env('APP_CLOSE'))
            return $this->autoReturn("系统即将上线,敬请期待", 404, url('/', [], env('APP_SECURE')));

        if (!$this->isFirstVisit()) {
            return redirect(url('welcome', [], env('APP_SECURE')));
        }

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
                'title' => '方寸堂 - 不止不同',
                'link' => $this->myShareUrl(url('/', [], env('APP_SECURE'))),
                'img' => fct_cdn('/img/mobile/share_logo.png', true),
                'desc' => '历经万千时间，倾力打造寻觅东方紫砂的平台。',
            ],
        ]);
    }
}