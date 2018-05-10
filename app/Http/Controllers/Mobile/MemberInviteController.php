<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-5-10
 * Time: 下午4:16
 */

namespace App\Http\Controllers\Mobile;


use App\Member;

class MemberInviteController extends BaseController
{
    public function getShare()
    {
        $member = Member::getAuth();

        return view('invite.share', [
            'title' => fct_title('售后详情'),
            'user' => (object) [
                'userName' =>$member->userName,
                'headPortrait' => $member->headPortrait,
            ],
        ]);
    }
}