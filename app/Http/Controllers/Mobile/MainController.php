<?php

namespace App\Http\Controllers\Mobile;

use App\Base;
use App\Exceptions\BusinessException;
use App\FctCommon;
use App\FctValidator;
use App\Main;
use Illuminate\Http\Request;

/**默认入口页面
 * Class MainController
 * @package App\Http\Controllers\Mobile
 */
class MainController extends BaseController
{
    /**商城首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');
        $levelId = $request->get('level_id');

        return view('index', Main::index($categoryId, $levelId));
    }

    /**欢迎页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(Request $request)
    {
        $result = Main::welcome();
        $result['title'] = '欢迎使用';

        return view('welcome', $result);
    }

    public function sendCaptcha(Request $request)
    {
        $cellphone = $request->get('cellphone');
        $action = $request->get('action');

        try {

            FctValidator::hasMobile($cellphone);

            $sessionId = FctCommon::createMobileSessionId();
            $result = Base::sendCaptcha($cellphone, $sessionId, $request->ip(), $action);

            return $this->autoReturn($result->message, '', $result->code, $result->data);

        } catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function newCoupon(Request $request)
    {
        return view('new-coupon');
    }

    public function downloadApp(Request $request)
    {
        return view('download-app');
    }

    public function success()
    {
        return view('success');
    }

}
