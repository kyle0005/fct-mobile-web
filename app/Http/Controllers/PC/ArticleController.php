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
            $result = Article::getArticles($page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        $html = '';
        foreach ($result->entries as $article)
        {
            $url = $article->urlType ? url('articles/' . $article->id) : $article->url;
            $html .= '<div class="yw-news-li"><div class="yw-news-detail">'
                . '<h5 class="yw-news-title"><a href="javascript:;" data-urltype="'
                . $article->urlType
                . '" class="news-link" data-url="' . $url
                . '" target="_blank">'. $article->title .'</a></h5><div class="yw-news-time">'
                . '<span class="yw-news-tag">'. $article->categoryName
                . '</span><time>' . date('Y-m-d', intval($article->createTime / 1000))
                . '</time></div><p class="yw-news-sum">' . $article->intro .'</p>'
                . '<p class="yw-news-more"><a href="javascript:;" data-urltype="'
                . $article->urlType
                . '" class="news-link" data-url="' . $url
                . '" target="_blank" class="yw-news-more-a">阅读更多&gt;</a></p></div></div>';
        }
        $result->entries = $html;

        return $this->returnAjaxSuccess('获取成功', null, $result);
    }

    public function show(Request $request, $id)
    {
        if ($id < 1)
        {
            return $this->autoReturn('新闻不存在');
        }

        try
        {
            $result = Article::getArticle($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        $result = '<div class="yw-news-li"><div class="yw-news-detail"><h5 class="yw-news-title"><a href="'
            . url('articles/' . $result->id)
            . '" target="_blank">' . $result->title . '</a></h5><div class="yw-news-time"><span class="yw-news-tag">'
            . $result->categoryName
            . '</span><time>' . date('Y-m-d', intval($result->createTime / 1000)) . '</time><span>&nbsp;来源：'
            . $result->source
            . '</span></div><p class="yw-news-sum">'
            . $result->content
            . '</p></div></div></div>';

        return $this->returnAjaxSuccess('获取成功', null, $result);
    }
}