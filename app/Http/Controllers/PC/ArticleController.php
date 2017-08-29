<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-8-29
 * Time: 下午3:49
 */

namespace App\Http\Controllers\PC;


use App\Article;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{

    public function index(Request $request)
    {
        $page = intval($request->get('page', 1));
        try
        {
            $result = Article::getArtists($page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return $this->returnAjaxSuccess('获取成功', null, $result);
    }
}