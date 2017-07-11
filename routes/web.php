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
Route::get('/', 'Mobile\MainController@index');
Route::get('welcome', 'Mobile\MainController@welcome');
Route::get('download/app', 'Mobile\MainController@downloadApp');
//领取优惠券
Route::get('coupons/new', 'Mobile\MainController@newCoupon');
//操作成功跳转页面
Route::get('success', 'Mobile\MainController@success');
//用户
Route::match(['get', 'post'], 'login', 'Mobile\MemberController@login');
//Route::match(['get', 'post'], 'register', 'Mobile\MemberController@register');
Route::match(['get', 'post'], 'forget-password', 'Mobile\MemberController@forgetPassword');
Route::any('logout', 'Mobile\MemberController@logout');
//发送短信验证码
Route::post('send-captcha', 'Mobile\MainController@sendCaptcha');
//查看物流信息
Route::match(['get', 'post'], 'find-express', 'Mobile\MainController@findExpress');

//产品详情
//ajax获取评论数据
Route::get('products/{product_id}/comments', 'Mobile\ProductController@getProductComments')
    ->where('product_id', '[0-9]+');
//ajax获取艺术家数据
Route::get('products/{product_id}/artists', 'Mobile\ProductController@getProductArtists')
    ->where('product_id', '[0-9]+');
//ajax获取泥料数据
Route::get('products/{product_id}/materials', 'Mobile\ProductController@getProductaMaterials')
    ->where('product_id', '[0-9]+');

Route::resource('products', 'Mobile\ProductController', ['show']);

//大师
//ajax获取大师评论数据
Route::get('artists/{artist_id}/comments', 'Mobile\ArtistCommentController@index')
    ->where('artist_id', '[0-9]+');
//大师动态
Route::get('artists/{artist_id}/dynamics', 'Mobile\ArtistDynamicController@index')
    ->where('artist_id', '[0-9]+');
//大师动态
Route::get('artists/{artist_id}/products', 'Mobile\ArtistController@products')
    ->where('artist_id', '[0-9]+');
Route::resource('artists', 'Mobile\ArtistController', ['index', 'show']);

//wiki
Route::get('wiki', 'Mobile\WikiController@index');
Route::get('wiki/item', 'Mobile\WikiController@show');

/** 用户需要登录后操作 */
Route::group(['middleware' => 'auth'], function () {
    //更新资料
    Route::match(['get', 'post'], 'update-info', 'Mobile\MemberController@updateInfo');
    //修改密码
    Route::match(['get', 'post'], 'change-password', 'Mobile\MemberController@changePassword');
    //实名认证并绑定银行卡
    Route::match(['get', 'post'], 'real-auth', 'Mobile\MemberController@realAuth');
    //地址管理
    //设置默认
    Route::match(['get', 'post'], 'address/{id}/default', 'Mobile\MemberAddressController@setDefault')
        ->where('id', '[0-9]+');
    //删除
    Route::post('address/{id}/delete', 'Mobile\MemberAddressController@setDelete')
        ->where('id', '[0-9]+');
    Route::resource('address', 'Mobile\MemberAddressController',
        ['index', 'create', 'edit', 'store', 'show']);

    //购物车
    //购物车中删除
    Route::post('carts/{id}/delete', 'Mobile\ShoppingCartController@setDelete')
        ->where('id', '[0-9]+');
    Route::resource('carts', 'Mobile\ShoppingCartController', ['index', 'store']);

    //订单
    //取消
    Route::post('orders/{order_id}/cancel', 'Mobile\OrderController@setCancel')
        ->where('order_id', '[0-9]+');
    //评论
    Route::post('orders/{order_id}/comments', 'Mobile\ProductCommentController@store')
        ->where('order_id', '[0-9]+');
    Route::resource('orders', 'Mobile\OrderController', ['index', 'create', 'store', 'show']);

    //支付
    //支付通知
    Route::match(['get', 'post'], 'notice', 'Mobile\PayController@notice');
    Route::match(['get', 'post'], 'callback', 'Mobile\PayController@callback');
    Route::resource('pay', 'Mobile\PayController', ['index', 'store', 'show']);

    //退货
    Route::resource('refunds', 'Mobile\RefundController', ['index', 'create', 'store', 'show']);
    //充值
    Route::resource('recharge', 'Mobile\RechargeController', ['index', 'create', 'store', 'show']);
    //提现
    Route::resource('withdraw', 'Mobile\WithdrawController', ['index', 'create', 'store', 'show']);

    //收藏
    Route::resource('favorites', 'Mobile\FavoriteController', ['index', 'store']);
    //折扣
    Route::resource('discounts', 'Mobile\DiscountController', ['index', 'show']);
    //优惠券
    Route::resource('coupons', 'Mobile\CouponController', ['index', 'store', 'show']);
    //结算
    Route::resource('settlement', 'Mobile\SettlementController', ['index', 'show']);

    //大师评论
    Route::post('artists/{artist_id}/comments', 'Mobile\ArtistCommentController@store')
        ->where('artist_id', '[0-9]+');

});





