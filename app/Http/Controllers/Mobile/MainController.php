<?php

namespace App\Http\Controllers\Mobile;

use App\Base;
use App\Coupon;
use App\Exceptions\BusinessException;
use App\FctCommon;
use App\FctValidator;
use App\Main;
use App\ProductCategory;
use Illuminate\Http\Request;

/**默认入口页面
 * Class MainController
 * @package App\Http\Controllers\Mobile
 */
class MainController extends BaseController
{
    /**商城首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws BusinessException
     */
    public function index(Request $request)
    {
        if (!$this->isFirstVisit()) {
            return redirect(url('welcome', [], env('APP_SECURE')));
        }
        //?code={code}&level_id={id}
        $categoryId = $request->get('code');
        $levelId = $request->get('level_id');
        $pageIndex = $request->get('page', 1);

        try
        {
            $result = Main::getHome($categoryId, $levelId, $pageIndex);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
        {
            return $this->returnAjaxSuccess($request->message, "", $result->pagination);
        }
        else
        {

            $member = $this->memberLogged(false);
            $hasLogin = $member && $member->memberId > 0 ? 1 : 0;

            $shareUrl = $this->myShareUrl(url('/products', [], env('APP_SECURE')));

            return view('index', [
                'title' => fct_title(),
                'categories' => ProductCategory::getCategories(),
                'levels' =>  $result->goodsGradeList,
                'products' => $result->pagination,
                'hasNewVisitor' => $this->hasNewVisitor(),
                'hasLogin' => $hasLogin,
                'share' => [
                    'title' => '方寸堂 - 不只不同',
                    'link' => $shareUrl,
                    'img' => fct_cdn('/img/mobile/share_logo.png', true),
                    'desc' => '汇聚东方美学匠心之作的紫砂交流电商平台。',
                ],
                ]);
        }
    }

    /**欢迎页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(Request $request)
    {
        //设置第一次访问过了
        $this->setFirstVisit();
        $result = Main::welcome();
        $shareUrl = $this->myShareUrl(url('welcome', [], env('APP_SECURE')));

        return view('welcome', [
            'title' => fct_title(),
            'slides' => json_encode($result, JSON_UNESCAPED_UNICODE),
            'share' => [
                'title' => '方寸堂 - 不只不同',
                'link' => $shareUrl,
                'img' => fct_cdn('/img/mobile/share_logo.png', true),
                'desc' => '汇聚东方美学匠心之作的紫砂交流电商平台。',
            ],
        ]);
    }

    public function sendCaptcha(Request $request)
    {
        $cellphone = $request->get('cellphone');
        $action = $request->get('action');

        try {

            FctValidator::hasMobile($cellphone);

            $sessionId = FctCommon::createMobileSessionId();
            $result = Base::sendCaptcha($cellphone, $sessionId, $request->ip(), $action);

            $this->returnAjaxSuccess($result->msg);

        } catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }

    public function newCoupon(Request $request)
    {
        $productId = $request->get('product_id', 0);
        try
        {
            $result = Coupon::getCoupons($productId);
        } catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('coupon.new', [
            'title' => fct_title('领取优惠券'),
            'categories' => ProductCategory::getCategories(),
            'coupons' => $result,
        ]);
    }

    public function findExpress(Request $request, $express_number)
    {

        return view('express');
    }

    public function downloadApp(Request $request)
    {
        return view('download-app');
    }

    public function error(Request $request)
    {
        $message = $request->get('message', '');

        $redirectUrl = $request->get(env('REDIRECT_KEY'), '');

        return $this->errorPage($message, $redirectUrl);
    }

    public function getHelp(Request $request)
    {
        try
        {
            $result = Main::getHelp();
        } catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('help', [
            'title' => fct_title('帮助中心'),
            'articleCategories' => $result->categoryList,
            'articles' => $result->articleList,
            'share' => [
                'title' => '方寸堂 - 帮助中心',
                'link' => $this->myShareUrl(url('help', [], env('APP_SECURE'))),
                'img' => fct_cdn('/img/mobile/question-mark.png', true),
                'desc' => '方寸堂官方帮助中心,这里为用户提供平台使用常见问题的搜索与解答…',
            ],
        ]);
    }

}
