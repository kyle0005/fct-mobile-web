<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

/** 不用登录页面 */
Route::group(['domain' => env('PC_DOMAIN', 'www.fangcun.com')], function () {
    Route::get('/', 'PC\MainController@index');
    Route::resource('articles', 'PC\ArticleController', ['index', 'show']);
});

Route::group(['domain' => env('MOBILE_DOMAIN', 'm.fangcun.com')], function ()
{
    //新首页
    Route::get('/', 'Mobile\SpecialController@home');
    //搜索页
    Route::get('search', 'Mobile\SearchController@index');
    //促销详情
    Route::get('discounts/{id}', 'Mobile\DiscountController@show')
        ->where('id', '[0-9]+');
    //原首页变更为宝贝列表页
    Route::get('products', 'Mobile\MainController@index');
    //欢迎页
    Route::get('welcome', 'Mobile\MainController@welcome');
    //注册或邀请有礼
    Route::get('gift/detail', 'Mobile\GiftController@signup');
    //分享js接口
    Route::get('help', 'Mobile\MainController@getHelp');
    //app下载
    Route::get('download/app', 'Mobile\MainController@downloadApp');
    //领取优惠券
    Route::get('coupons/new', 'Mobile\MainController@newCoupon');
    //折扣
    Route::resource('discounts', 'Mobile\DiscountController', ['index', 'show']);
    //操作成功跳转页面
    Route::get('error', 'Mobile\MainController@error');
    //用户
    Route::match(['get', 'post'], 'login', 'Mobile\MemberController@login');
    //第三方授权
        //授权回调
        Route::get('oauth/callback', 'Mobile\MemberController@oAuthCallback');
        //绑定第三方授权
        Route::match(['get', 'post'], 'oauth/bind', 'Mobile\MemberController@oAuthBind');
    Route::get('oauth', 'Mobile\MemberController@oAuth');
    //修改密码
    Route::match(['get', 'post'], 'forget-password', 'Mobile\MemberController@forgetPassword');
    //退出
    Route::any('logout', 'Mobile\MemberController@logout');
    //发送短信验证码
    Route::post('send-captcha', 'Mobile\MainController@sendCaptcha');
    //查看物流信息
    Route::match(['get', 'post'], 'find-express', 'Mobile\MainController@findExpress');
    //产品详情
    Route::resource('products', 'Mobile\ProductController', ['show']);
        //ajax获取评论数据
        Route::get('products/{product_id}/comments', 'Mobile\ProductController@getProductComments')
            ->where('product_id', '[0-9]+');
        //ajax获取艺术家数据
        Route::get('products/{product_id}/artists', 'Mobile\ProductController@getProductArtists')
            ->where('product_id', '[0-9]+');
        //ajax获取泥料数据
        Route::get('products/{product_id}/materials', 'Mobile\ProductController@getProductaMaterials')
            ->where('product_id', '[0-9]+');

    //拍卖
    Route::resource('auction', 'Mobile\AuctionProductController', ['index', 'show']);
        Route::resource('auction/artist', 'Mobile\AuctionArtistController', ['show']);

    //大师
    Route::resource('artists', 'Mobile\ArtistController', ['index', 'show']);
        //ajax获取大师评论数据
        Route::get('artists/{artist_id}/comments', 'Mobile\ArtistCommentController@index')
            ->where('artist_id', '[0-9]+');
        //大师动态
        Route::get('artists/{artist_id}/dynamics', 'Mobile\ArtistDynamicController@index')
            ->where('artist_id', '[0-9]+');
        //大师动态
        Route::get('artists/{artist_id}/products', 'Mobile\ArtistController@products')
            ->where('artist_id', '[0-9]+');
    //wiki
    Route::get('wiki', 'Mobile\WikiController@index');
        Route::get('wiki/item', 'Mobile\WikiController@show');

    /** 用户需要登录后操作 */
    Route::group(['middleware' => 'auth'], function ()
    {
        Route::get('express', 'Mobile\ExpressController@index');
        //上传图片
        //Route::get('upload/image', 'Mobile\UploadController@image');
        Route::post('upload/image', 'Mobile\UploadController@image');

        //拍卖提醒
        Route::post('remind', 'Mobile\AuctionRemindController@store');
        //拍卖报名
        Route::post('signup', 'Mobile\AuctionSignupController@store');
        //拍卖报名
        Route::post('bid', 'Mobile\AuctionBidController@store');
        //拍卖创建订单
        Route::get('auction/order/create', 'Mobile\AuctionOrderController@create');
        Route::post('auction/order', 'Mobile\AuctionOrderController@store');


        //大师评论
        Route::post('artists/{artist_id}/comments', 'Mobile\ArtistCommentController@store')
            ->where('artist_id', '[0-9]+');

        //购物车
        Route::resource('carts', 'Mobile\ShoppingCartController', ['index', 'store']);
        //购物车中删除
        Route::post('carts/{id}/delete', 'Mobile\ShoppingCartController@setDelete')
            ->where('id', '[0-9]+');
        Route::get('address/choose', 'Mobile\MemberAddressController@choose');
        //订单
        Route::resource('orders', 'Mobile\OrderController', ['create', 'store']);

        //用户中心
        Route::get('my', 'Mobile\MemberController@index');

        //拍卖报名列表
        Route::get('my/auction/signup', 'Mobile\AuctionSignupController@index');
        //拍卖订单
        Route::resource('my/auction/order', 'Mobile\AuctionOrderController', ['index', 'show']);

        //用户中心订单
        Route::get('my/orders', 'Mobile\OrderController@index');
            Route::get('my/orders/{order_id}', 'Mobile\OrderController@show')
                ->where('order_id', '[0-9]+');
            //物流详情
            Route::get('my/orders/{order_id}/express', 'Mobile\OrderController@getExpress')
                ->where('order_id', '[0-9]+');
            //取消
            Route::post('my/orders/{order_id}/cancel', 'Mobile\OrderController@setCancel')
                ->where('order_id', '[0-9]+');
            //确认收货
            Route::post('my/orders/{order_id}/finish', 'Mobile\OrderController@setFinish')
                ->where('order_id', '[0-9]+');
            //申请发票
            Route::match(['get', 'post'], 'my/orders/{order_id}/invoice', 'Mobile\OrderController@saveOrderInvoice')
                ->where('order_id', '[0-9]+');
            //评论
            Route::get('my/orders/{order_id}/comments/create', 'Mobile\OrderCommentController@create')
                ->where('order_id', '[0-9]+');
            Route::post('my/orders/{order_id}/comments', 'Mobile\OrderCommentController@store')
                ->where('order_id', '[0-9]+');
            //退货
            Route::resource('my/refunds', 'Mobile\RefundController', ['index', 'create', 'store', 'show']);
                //关闭申请
                Route::post('my/refunds/{id}/cancel', 'Mobile\RefundController@setCancel');
                //退回宝贝
                Route::post('my/refunds/{id}/express', 'Mobile\RefundController@saveRefundExpress');

        //我的钱包
        Route::get('my/account', 'Mobile\MemberAccountController@wallet');
            //实名认证并绑定银行卡
            Route::match(['get', 'post'], 'my/account/real-auth', 'Mobile\MemberController@realAuth');
            //充值
            Route::resource('my/account/recharge', 'Mobile\RechargeController', ['index', 'create', 'store', 'show']);
            //提现
            Route::resource('my/account/withdraw', 'Mobile\WithdrawController', ['index', 'create', 'store', 'show']);
            //结算
            Route::resource('my/account/settlement', 'Mobile\SettlementController', ['index', 'show']);
            //帐户明细
            Route::resource('my/account/logs', 'Mobile\MemberAccountController', ['index']);

        //更新资料
        Route::match(['get', 'post'], 'my/profile', 'Mobile\MemberController@updateInfo');
        //修改密码
        Route::match(['get', 'post'], 'my/change-password', 'Mobile\MemberController@changePassword');
        //优惠券
        Route::resource('my/coupons', 'Mobile\CouponController', ['index', 'store', 'show']);
        Route::post('my/coupons/use', 'Mobile\CouponController@useCoupon');
        //收藏
        Route::resource('my/favorites', 'Mobile\FavoriteController', ['index', 'store']);

        //地址管理
        Route::get('my/address', 'Mobile\MemberAddressController@index');
            Route::post('my/address', 'Mobile\MemberAddressController@store');
            //创建
            Route::get('my/address/create', 'Mobile\MemberAddressController@create');
            //修改
            Route::get('my/address/edit', 'Mobile\MemberAddressController@edit');
            Route::get('my/address/{id}/edit', 'Mobile\MemberAddressController@edit');
            //设置默认
            Route::post('my/address/default', 'Mobile\MemberAddressController@setDefault');
            Route::post('my/address/{id}/default', 'Mobile\MemberAddressController@setDefault')
                ->where('id', '[0-9]+');
            //删除
            Route::post('my/address/delete', 'Mobile\MemberAddressController@setDelete');
            Route::post('my/address/{id}/delete', 'Mobile\MemberAddressController@setDelete')
                ->where('id', '[0-9]+');
        //分享
        Route::get('my/share', 'Mobile\ShareController@index');
            Route::get('my/share/{id}', 'Mobile\ShareController@show')
                ->where('id', '[0-9]+');
            Route::get('my/share/auction/orders', 'Mobile\ShareController@getAuctionOrders');
            Route::get('my/share/orders', 'Mobile\ShareController@getOrders');
                Route::get('my/share/orders/{order_id}', 'Mobile\ShareController@getOrder')
                    ->where('order_id', '[0-9]+');

        //申请开店
        Route::resource('store', 'Mobile\MemberStoreController', ['create', 'store']);
        //联盟
        Route::get('my/alliance', 'Mobile\AllianceController@index');
            //联盟考核列表
            Route::get('my/alliance/kpi', 'Mobile\AllianceKPIController@index');
            //联盟成员列表
            Route::get('my/alliance/store', 'Mobile\AllianceStoreController@index');

    });
});





