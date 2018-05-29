<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-5-10
 * Time: 下午4:16
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\Member;
use App\MemberInvite;

class MemberInviteController extends BaseController
{
    public function index()
    {
        try
        {
            $tops = MemberInvite::getTop();
            $invites = MemberInvite::findInvite();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        $member = $this->memberLogged(false);
        $hasLogin = $member && $member->memberId > 0 ? 1 : 0;
        $shareUrl = $this->myShareUrl(url('/', [], env('APP_SECURE')));
        $title = $hasLogin ? ($member->userName . '邀请您领红包啦！') : '方寸堂 - 注册领红包';

        return view('invite.index', [
            'title' => fct_title($title),
            'entity' => (object) [
                'tops' => $tops,
                'invites' => $invites,
            ],
            'hasLogin' => $hasLogin,
            'share' => [
                'title' => '方寸堂 - ' . $title,
                'link' => $shareUrl,
                'img' => fct_cdn('/img/mobile/share_logo.png', true),
                'desc' => '汇聚东方美学匠心之作的紫砂交流电商平台。',
            ],
        ]);
    }

    public function getShare()
    {
        $member = Member::getAuth();

        return view('invite.share', [
            'title' => fct_title('生成分享图片'),
            'user' => (object) [
                'userName' =>mb_strlen($member->userName, 'utf-8') > 8
                    ? (mb_substr($member->userName, 0, 7) . '...') : $member->userName,
                'headPortrait' => $member->headPortrait,
            ],
            "qrcodeUrl" => image_base64(gen_qrcode(urlencode($this->myShareUrl(url('/', [], env('APP_SECURE')))))),
            "backgroundUrl" => image_base64(fct_cdn('/img/mobile/reg_invite_bg.png', true)),
            "logoUrl" => image_base64(fct_cdn('/img/mobile/i_home_d.png',true))
        ]);
    }
}