<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午9:59
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\Search;
use Illuminate\Http\Request;

class SearchController extends BaseController
{

    public function index(Request $request)
    {
        $keyword = $request->get('keyword', '');

        try
        {
            $result = Search::searchAll($keyword);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("获取成功", null, $result);


        return view('search.index', [
            'title' => fct_title($keyword ? "搜索 “ $keyword ”" : "搜索"),
            'keyword' => $keyword,
            'entities' => $result,
        ]);
    }

    public function searchProducts(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $category_id = $request->get('category_id', '');
        $artist_id = $request->get('author', 0);
        $volume_min = $request->get('volume_min', 0);

        $volume_max = $request->get('volume_max', 0);
        $price_min = $request->get('price_min', 0);
        $price_max = $request->get('price_max', 0);
        $sort = $request->get('sort', 0);

        $page_index = $request->get('page', 1);
        $is_search_filter = !$request->ajax();

        try
        {
            $result = Search::searchProducts(
                $keyword, $category_id, $artist_id, $volume_min,
                $volume_max, $price_min, $price_max, $sort,
                $page_index, $is_search_filter
            );
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("获取成功", null, $result->products);


        return view('search.product', [
            'title' => fct_title($keyword ? "搜索 “ $keyword ”" : "搜索"),
            'result' => $result,
            'share' => [
                'title' => '选壶 - 方寸堂',
                'link' => $$this->myShareUrl(url('/products', [], env('APP_SECURE'))),
                'img' => fct_cdn('/img/mobile/share_logo.png', true),
                'desc' => 'N＋寻觅人，在此相遇邂逅一触即爱的好物。',
            ],
        ]);
    }

}