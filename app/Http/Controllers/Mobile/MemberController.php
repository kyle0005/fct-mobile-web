<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\FctCommon;
use App\FctValidator;
use App\Member;
use Illuminate\Http\Request;

/**用户操作
 * Class MemberController
 * @package App\Http\Controllers\Mobile
 */
class MemberController extends BaseController
{
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
                Member::login($cellphone, $password, $captcha, $sessionId, $request->ip());
                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('登录成功', $this->getRedirectSourceUrl());
                //return redirect($this->getRedirectSourceUrl(), 301, ['token' => $member->token], true);
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }


        return view('login', ['title' => "用户登录"]);
    }

    /**注册
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            try
            {
                $cellphone = FctCommon::trimAll($request->get('cellphone'));
                $password = null;
                FctValidator::hasMobile($cellphone);

                $captcha = FctCommon::trimAll($request->get('captcha'));
                FctValidator::hasMobileCaptcha($captcha);
                //csrf验证

                //用户登录操作
                $member = [];

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('注册成功');
                //return redirect($this->getRedirectSourceUrl(), 301, ['token' => $member->token], true);
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }
        return view('register');
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
                $gender = FctCommon::trimAll($request->get('gender'));
                $weixin = FctCommon::trimAll($request->get('weixin'));

                //csrf验证

                //用户登录操作
                Member::updateInfo($username, $gender, $weixin);

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('修改成功');
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }
        $result = [
            'title' => '更新信息',
            'member' => $member,
        ];

        return view('update', $result);
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
                return $this->returnAjaxSuccess('密码修改成功');
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }

        $result = [
            'title' => '修改密码',
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
                return $this->returnAjaxSuccess('密码找回成功');
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }
        return view('forget-password', ['title' => '找回密码']);
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
                $idCardNo = FctCommon::trimAll($request->get('idcard_no'));
                $idCardImageUrl = FctCommon::trimAll($request->get('idcard_image_url'));
                $bankName = FctCommon::trimAll($request->get('bank_name'));
                $bankAccount = FctCommon::trimAll($request->get('bank_account'));

                FctValidator::hasRealName($name);
                FctValidator::hasIDCardNO($idCardNo);
                FctValidator::hasRequire($idCardImageUrl, '身份证图片');
                FctValidator::hasBankInfo($bankName, $bankAccount);

                //csrf验证

                //用户登录操作
                Member::realAuth($name, $idCardNo, $idCardImageUrl, $bankName, $bankAccount);

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('提交认证信息成功');
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }

        $result = [
            'title' => '修改密码',
            'member' => $member,
        ];

        return view('real-auth', $result);
    }

    /**退出
     * @param Request $request
     */
    public function logout(Request $request)
    {

    }
}
