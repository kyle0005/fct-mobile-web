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

        return view('invite.index', [
            'title' => fct_title('邀请分享'),
            'entity' => (object) [
                'tops' => $tops,
                'invites' => $invites,
            ],
        ]);
    }

    public function getShare()
    {
        $member = Member::getAuth();

        return view('invite.share', [
            'title' => fct_title('生成分享图片'),
            'user' => (object) [
                'userName' =>$member->userName,
                'headPortrait' => $member->headPortrait,
            ],
            "qrcodeUrl" => image_base64(gen_qrcode(urlencode($this->myShareUrl(url('/', [], env('APP_SECURE')))))),
            "backgroundUrl" => image_base64(fct_cdn('/img/mobile/reg_invite_bg.png', true)),
            "logoUrl" => image_base64(fct_cdn('/img/mobile/i_home_d.png',true))
        ]);
    }
}