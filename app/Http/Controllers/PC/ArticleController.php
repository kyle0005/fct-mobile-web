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
            $url = $article->urlType ? url('articles/' . $article->id).'?current='.$page : $article->url;
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

        $html .= '<a href="javascript:" class="yw-btn-blue jsLayMore" data-page="'
            . $result->pager->next . '">查看更多</a>';

        $result->entries = $html;

        return $this->returnAjaxSuccess('获取成功', null, $result);
    }

    public function show(Request $request, $id)
    {
        if ($id < 1)
        {
            return $this->autoReturn('新闻不存在');
        }

        $current = $request->get('current', 1);

        try
        {
            $result = Article::getArticle($id, $current);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        $prevClick = '';
        $nextClick = '';
        if ($result->prevId > 0)
            $prevClick = '<a href="javascript:;" class="prev js-opt" data-url="'
                . url('articles/' . $result->prevId)
                . '"><img src="'.fct_cdn('/img/fct/p_prev.png').'"></a>';
        if ($result->nextId > 0)
        $nextClick = '<a href="javascript:;" class="next js-opt" data-url="'
            . url('articles/' . $result->nextId)
            . '"><img src="'.fct_cdn('/img/fct/p_next.png').'"></a>';

        $result = '<div class="yw-news-li"><div class="yw-news-detail"><h5 class="yw-news-title"><a href="'
            . url('articles/' . $result->id)
            . '" target="_blank">' . $result->title . '</a></h5><div class="yw-news-time"><span class="yw-news-tag">'
            . $result->categoryName
            . '</span><span>&nbsp;来源：'
            . $result->source
            . '</span><time>' . date('Y-m-d', intval($result->createTime / 1000))
            . '</time></div><div class="det-intro">' . $result->intro . '</div><p class="yw-news-sum">'
            . $result->content
            . '</p></div></div></div>'
            . '<div class="btn-container">' . $prevClick . $nextClick
            . '<a href="javascript:;" class="back" id="back"><img src="'
            . fct_cdn('/img/fct/p_back.png')
            . '"><span class="txt">返回全部</span></a></div>';

        return $this->returnAjaxSuccess('获取成功', null, $result);
    }
}