<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\FctCommon;
use App\FctValidator;
use App\Member;
use App\MemberOAuth;
use App\ProductCategory;
use Illuminate\Http\Request;

/**用户操作
 * Class MemberController
 * @package App\Http\Controllers\Mobile
 */
class MemberController extends BaseController
{
    public function oAuth(Request $request)
    {
        try
        {
            $result = MemberOAuth::getURL();
            return redirect($result);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }

    public function oAuthCallback(Request $request)
    {
        $code = $request->get('code', '');
        if (!$code)
        {
            return $this->autoReturn('授权失败');
        }

        try
        {
            $result = MemberOAuth::saveOAuth($code, $request->ip());
            if ($result && $result->memberId > 0)
                $redirectUrl = $this->getRedirectSourceUrl();
            else
                $redirectUrl = url('oauth/bind', [], env('APP_SECURE'))."?openid=$result->openId";

            return redirect($redirectUrl);
            //return $this->returnAjaxSuccess(($result ? '授权成功' : '授权完成,去绑定手机'), $redirectUrl);
        } catch (BusinessException $e) {

            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }

    public function oAuthBind(Request $request)
    {
        $openid = FctCommon::trimAll($request->get('openid'));

        if ($request->getMethod() == 'POST') {

            try
            {
                $cellphone = FctCommon::trimAll($request->get('cellphone'));
                $captcha = FctCommon::trimAll($request->get('captcha'));
                $sessionId = FctCommon::getMobileSessionId();

                FctValidator::hasMobile($cellphone);
                FctValidator::hasMobileCaptcha($captcha);

                MemberOAuth::bindOAuth($this->getInviterId(), $openid, $cellphone, $captcha, $sessionId, $request->ip());
                return $this->returnAjaxSuccess('授权成功', $this->getRedirectSourceUrl());
            }
            catch (BusinessException $e)
            {
                return $this->autoReturn($e->getMessage(), $e->getCode());
            }
        }

        return view("bind", [
            'title' => fct_title('微信绑定'),
            'openid' => $openid,
        ]);
    }


    /**用户登录
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->getMethod() == 'POST') {

            try
            {
                $cellphone = FctCommon::trimAll($request->get('cellphone'));
                $password = FctCommon::trimAll($request->get('password'));
                $captcha = FctCommon::trimAll($request->get('captcha'));
                $sessionId = "";
                FctValidator::hasMobile($cellphone);

                //检查是否有传入密码，如果没有再检查是否传入验证码，都没有表示用户非法提交
                if ($password)
                {
                    FctValidator::hasPassword($password);
                }
                elseif ($captcha)
                {
                    FctValidator::hasMobileCaptcha($captcha);
                    $sessionId = FctCommon::getMobileSessionId();
                }
                else
                {
                    FctValidator::illegalRequest();
                }

                //csrf验证
                //用户登录操作
                Member::login($this->getInviterId(), $cellphone, $password, $captcha, $sessionId, $request->ip());
                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('登录成功', $this->getRedirectSourceUrl());
                //return redirect($this->getRedirectSourceUrl(), 301, ['token' => $member->token], true);
            }
            catch (BusinessException $e)
            {
                return $this->autoReturn($e->getMessage(), $e->getCode());
            }
        }

        $this->cacheRedirectSourceUrl('', true);

        return view('login', ['title' => fct_title("用户登录")]);
    }

    /**更新
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function updateInfo(Request $request)
    {
        $member = $this->memberLogged();

        if ($request->getMethod() == 'POST') {
            try
            {
                $username = FctCommon::trimAll($request->get('username'));
                $avatar = FctCommon::trimAll($request->get('avatar'));
                $gender = FctCommon::trimAll($request->get('sex'));
                $birthday = FctCommon::trimAll($request->get('birthday'));
                $weixin = FctCommon::trimAll($request->get('weixin'));

                //csrf验证

                //用户登录操作
                Member::updateInfo($username, $avatar, $gender, $birthday, $weixin);

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('修改成功', url('my', [], env('APP_SECURE')));
            }
            catch (BusinessException $e)
            {
                return $this->autoReturn($e->getMessage(), $e->getCode());
            }
        }

        try
        {
            $result = Member::getMemberInfo();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        $result = [
            'title' => fct_title('更新信息'),
            'member' => $result,
        ];

        return view('member.profile', $result);
    }

    /**修改密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function changePassword(Request $request)
    {
        $member = $this->memberLogged();

        if ($request->getMethod() == 'POST') {
            try
            {
                $oldPassword = FctCommon::trimAll($request->get('old_password'));
                $newPassword = FctCommon::trimAll($request->get('new_password'));
                $confirmNewPassword = FctCommon::trimAll($request->get('confirm_new_password'));
                FctValidator::hasPassword($oldPassword, '旧密码');
                FctValidator::hasPassword($newPassword, '新密码');
                FctValidator::hasPassword($confirmNewPassword, '确认新密码');
                FctValidator::hasEqual($newPassword, $confirmNewPassword, '新密码', '确认新密码');

                //用户登录操作
                Member::changePassowrd($oldPassword, $newPassword);

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('密码修改成功', url('my', [], env('APP_SECURE')));
            }
            catch (BusinessException $e)
            {
                return $this->autoReturn($e->getMessage(), $e->getCode());
            }
        }

        $result = [
            'title' => fct_title('修改密码'),
            'member' => $member,
        ];

        return view('change-password');
    }

    /**忘记密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function forgetPassword(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            try
            {
                $cellphone = FctCommon::trimAll($request->get('cellphone'));
                $password = null;
                FctValidator::hasMobile($cellphone);

                $captcha = FctCommon::trimAll($request->get('captcha'));
                FctValidator::hasMobileCaptcha($captcha);

                $password = FctCommon::trimAll($request->get('password'));
                FctValidator::hasPassword($password);

                //csrf验证

                //用户登录操作
                $member = [];

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('密码找回成功', url('login', [], env('APP_SECURE')));
            }
            catch (BusinessException $e)
            {
                return $this->autoReturn($e->getMessage(), $e->getCode());
            }
        }
        return view('forget-password', ['title' => fct_title('找回密码')]);
    }

    /**实名认证和绑定银行卡
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function realAuth(Request $request)
    {
        $member = $this->memberLogged();

        if ($request->getMethod() == 'POST') {
            try
            {
                $name = FctCommon::trimAll($request->get('name'));
                $idCardNo = FctCommon::trimAll($request->get('IDcard'));
                $idCardImageUrl = FctCommon::trimAll($request->get('avatar'));
                $bankName = FctCommon::trimAll($request->get('bank'));
                $bankAccount = FctCommon::trimAll($request->get('bankAccount'));

                FctValidator::hasRealName($name);
                FctValidator::hasIDCardNO($idCardNo);
                FctValidator::hasRequire($idCardImageUrl, '身份证图片');
                FctValidator::hasBankInfo($bankName, $bankAccount);

                //csrf验证

                //用户登录操作
                Member::realAuth($name, $idCardNo, $idCardImageUrl, $bankName, $bankAccount);

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('提交认证信息成功', url('my/account', [], env('APP_SECURE')));
            }
            catch (BusinessException $e)
            {
                return $this->autoReturn($e->getMessage(), $e->getCode());
            }
        }

        try
        {
            $result = Member::getBanks();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        $result = [
            'title' => fct_title('实名认证'),
            'banks' => $result,
        ];

        return view('member.real-auth', $result);
    }

    /**退出
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Member::logout();
        return redirect(url('/', [], env('APP_SECURE')));
    }


    public function index(Request $request)
    {
        $member = Member::getAuth();

        return view("member.index", [
            'title' => fct_title('用户中心'),
            'memberBanner' => (object) [
                'userName' =>$member->userName,
                'headPortrait' => $member->headPortrait,
                'shopId' => $member->shopId,
            ],
            'categories' => ProductCategory::getCategories(),
        ]);
    }
}
