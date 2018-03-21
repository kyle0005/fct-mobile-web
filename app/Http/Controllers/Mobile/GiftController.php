<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-3-21
 * Time: 上午10:43
 */

namespace App\Http\Controllers\Mobile;


use Illuminate\Http\Request;

class GiftController extends BaseController
{

    public function signup(Request $request)
    {
        $member = $this->memberLogged(false);
        $shareUrl = $this->myShareUrl(url('login', [], env('APP_SECURE') . '/'));
        $hasLogin = $member && $member->memberId > 0 ? 1 : 0;
        $title = $hasLogin ? '推荐有好礼' : '注册领红包';

        return view('gift.signup', [
            'title' => fct_title($title),
            'hasLogin' => $hasLogin,
            'share' => [
                'title' => '方寸堂 - ' . $title,
                'link' => $shareUrl,
                'img' => fct_cdn('/img/mobile/share_logo.png', true),
                'desc' => '汇聚东方美学匠心之作的紫砂交流电商平台。',
            ],
        ]);
    }

}