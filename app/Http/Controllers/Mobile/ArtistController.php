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
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        $shareUrl = $this->myShareUrl(url('artists', [], env('APP_SECURE')));
        return view('artist.index', [
            'title' => fct_title('守艺人'),
            'entries' => $result->entries,
            'share' => [
                'title' => fct_title('守艺人'),
                'link' => $shareUrl,
                'img' => fct_cdn('/img/mobile/fc_logo.png', true),
                'desc' => '守一种精神 做一个“匠人”',
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
            if ($result)
                Artist::addVisitCount($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        $shareUrl = $this->myShareUrl(url('artists/' . $id, [], env('APP_SECURE')));
        $title = fct_title(isset($result->name) && $result->name ? $result->name : '守艺人详情');

        return view('artist.show', [
            'title' => $title,
            'artist' => $result,
            'categories' => ProductCategory::getCategories(),
            'share' => [
                'title' => $title,
                'link' => $shareUrl,
                'img' => $result->headPortrait,
                'desc' => $result->intro,
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
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }
}
