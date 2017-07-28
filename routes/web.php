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
Route::group(['domain' => 'www.fangcun.com'], function () {
    Route::get('/', 'PC\MainController@index');
});

Route::group(['domain' => 'test.fangcuntang.com'], function ()
{
    //首页
    Route::get('/', 'Mobile\MainController@index');
    //欢迎页
    Route::get('welcome', 'Mobile\MainController@welcome');
    //app下载
    Route::get('download/app', 'Mobile\MainController@downloadApp');
    //领取优惠券
    Route::get('coupons/new', 'Mobile\MainController@newCoupon');
    //折扣
    Route::resource('discounts', 'Mobile\DiscountController', ['index', 'show']);
    //操作成功跳转页面
    Route::get('success', 'Mobile\MainController@success');
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
        //大师评论
        Route::post('artists/{artist_id}/comments', 'Mobile\ArtistCommentController@store')
            ->where('artist_id', '[0-9]+');
        //上传图片
        //Route::get('upload/image', 'Mobile\UploadController@image');
        Route::post('upload/image', 'Mobile\UploadController@image');

        //购物车
        Route::resource('carts', 'Mobile\ShoppingCartController', ['index', 'store']);
        //购物车中删除
        Route::post('carts/{id}/delete', 'Mobile\ShoppingCartController@setDelete')
            ->where('id', '[0-9]+');
        Route::get('address/choose', 'Mobile\MemberAddressController@choose');
        //订单
        Route::resource('orders', 'Mobile\OrderController', ['create', 'store']);

        //用户中心
        Route::get('profile', 'Mobile\MemberController@index');

        //用户中心订单
        Route::get('settings/orders', 'Mobile\OrderController@index');
            Route::get('settings/orders/{order_id}', 'Mobile\OrderController@show')
                ->where('order_id', '[0-9]+');
            //取消
            Route::post('settings/orders/{order_id}/cancel', 'Mobile\OrderController@setCancel')
                ->where('order_id', '[0-9]+');
            //评论
            Route::get('settings/orders/{order_id}/comments/create', 'Mobile\OrderCommentController@create')
                ->where('order_id', '[0-9]+');
            Route::post('settings/orders/{order_id}/comments', 'Mobile\OrderCommentController@store')
                ->where('order_id', '[0-9]+');
            //退货
            Route::resource('settings/refunds', 'Mobile\RefundController', ['index', 'create', 'store', 'show']);

        //我的钱包
        Route::get('settings/account', 'Mobile\MemberAccountController@wallet');
            //实名认证并绑定银行卡
            Route::match(['get', 'post'], 'settings/account/real-auth', 'Mobile\MemberController@realAuth');
            //充值
            Route::resource('settings/account/recharge', 'Mobile\RechargeController', ['index', 'create', 'store', 'show']);
            //提现
            Route::resource('settings/account/withdraw', 'Mobile\WithdrawController', ['index', 'create', 'store', 'show']);
            //结算
            Route::resource('settings/account/settlement', 'Mobile\SettlementController', ['index', 'show']);
            //帐户明细
            Route::resource('settings/account/logs', 'Mobile\MemberAccountController', ['index']);

        //更新资料
        Route::match(['get', 'post'], 'settings/profile', 'Mobile\MemberController@updateInfo');
        //修改密码
        Route::match(['get', 'post'], 'settings/change-password', 'Mobile\MemberController@changePassword');
        //优惠券
        Route::resource('settings/coupons', 'Mobile\CouponController', ['index', 'store', 'show']);
        //收藏
        Route::resource('settings/favorites', 'Mobile\FavoriteController', ['index', 'store']);

        //地址管理
        Route::get('settings/address', 'Mobile\MemberAddressController@index');
            Route::post('settings/address', 'Mobile\MemberAddressController@store');
            //创建
            Route::get('settings/address/create', 'Mobile\MemberAddressController@create');
            //修改
            Route::get('settings/address/edit', 'Mobile\MemberAddressController@edit');
            Route::get('settings/address/{id}/edit', 'Mobile\MemberAddressController@edit');
            //设置默认
            Route::post('settings/address/default', 'Mobile\MemberAddressController@setDefault');
            Route::post('settings/address/{id}/default', 'Mobile\MemberAddressController@setDefault')
                ->where('id', '[0-9]+');
            //删除
            Route::post('settings/address/delete', 'Mobile\MemberAddressController@setDelete');
            Route::post('settings/address/{id}/delete', 'Mobile\MemberAddressController@setDelete')
                ->where('id', '[0-9]+');
        //分享
        Route::resource('settings/share', 'Mobile\ShareController', ['index']);
    });
});





