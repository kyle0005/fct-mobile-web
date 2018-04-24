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

        return view('search.index', [
            'title' => fct_title($keyword ? "搜索 “ $keyword ”" : "搜索"),
            'entities' => $result,
        ]);
    }

}