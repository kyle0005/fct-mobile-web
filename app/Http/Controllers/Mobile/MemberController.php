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
                $username = FctCommon::trimAll($request->get('username'));
                $password = null;
                FctValidator::hasMobile($username);

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
        if ($request->getMethod() == 'POST') {
            try
            {
                $username = FctCommon::trimAll($request->get('username'));
                $password = null;
                FctValidator::hasMobile($username);
                //csrf验证

                //用户登录操作
                $member = [];

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('修改成功');
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }
        return view('update');
    }

    /**修改密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function changePassword(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            try
            {
                //csrf验证

                //用户登录操作
                $member = [];

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('密码修改成功');
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }
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
                $username = FctCommon::trimAll($request->get('username'));
                $password = null;
                FctValidator::hasMobile($username);

                $captcha = FctCommon::trimAll($request->get('captcha'));
                FctValidator::hasMobileCaptcha($captcha);

                $password = FctCommon::trimAll($request->get('password'));
                FctValidator::hasPassword($password);

                //csrf验证

                //用户登录操作
                $member = [];

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('密码修改成功');
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
        if ($request->getMethod() == 'POST') {
            try
            {
                //csrf验证

                //用户登录操作
                $member = [];

                //成功返回成功提示和跳转的url
                return $this->returnAjaxSuccess('密码修改成功');
            }
            catch (BusinessException $e)
            {
                return $this->returnAjaxError($e->getMessage());
            }
        }
        return view('real-auth');
    }

    /**退出
     * @param Request $request
     */
    public function logout(Request $request)
    {

    }
}
