<?php

namespace App\Http\Controllers\Mobile;

use App\Artist;
use App\Exceptions\BusinessException;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;

/**大师
 * Class ArtistController
 * @package App\Http\Controllers\Mobile
 */
class ArtistController extends BaseController
{
    /**大师首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        try
        {
            $result = Artist::getArtists($page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        $shareUrl = url('artists');
        $shopId = intval($request->get(env('SHARE_SHOP_ID_KEY')));
        if ($shopId > 0) {
            $this->setShopId();
            $shareUrl = $shareUrl . '?'.env('SHARE_SHOP_ID_KEY').'=' .$shopId;
        }

        return view('artist.index', [
            'title' => '守艺人',
            'entries' => $result->entries,
            'share' => [
                'title' => '守艺人',
                'link' => $shareUrl,
                'img' => 'http://test.fangcuntang.com/images/logo.png',
                'desc' => '艺术家',
            ]
        ]);
    }

    /**大师详情
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        try
        {
            $result = Artist::getArtist($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        $shareUrl = url('artists/' . $id);
        $shopId = intval($request->get(env('SHARE_SHOP_ID_KEY')));
        if ($shopId > 0) {
            $this->setShopId();
            $shareUrl = $shareUrl . '?'.env('SHARE_SHOP_ID_KEY').'=' .$shopId;
        }

        return view('artist.show', [
            'title' => (isset($result->name) && $result->name ? $result->name : '守艺人详情'),
            'artist' => $result,
            'categories' => ProductCategory::getCategories(),
            'share' => [
                'title' => $result['title'],
                'link' => $shareUrl,
                'img' => 'http://test.fangcuntang.com/images/logo.png',
                'desc' => '艺术家',
            ]
        ]);
    }

    public function products(Request $request, $artist_id)
    {

        try
        {
            $result = Product::getPrdocutsByArtistId($artist_id);
            return $this->returnAjaxSuccess("获取作品列表成功", null, $result);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }
}
