<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-11
 * Time: 下午3:14
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\ProductCategory;
use App\Wiki;
use Illuminate\Http\Request;

class WikiController extends BaseController
{

    public function index(Request $request)
    {
        try
        {
            $result = Wiki::getHome();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        $shareUrl = $this->myShareUrl(url('wiki', [], env('APP_SECURE')));

        return view('wiki.index', [
            'title' => fct_title('百科'),
            'categories' => ProductCategory::getCategories(),
            'wikiCategories' => $result->wikiCategories,
            'materials' => $result->materials,
            'articles' =>  $result->articles,
            'share' => [
                'title' => fct_title('百科'),
                'link' => $shareUrl,
                'img' => fct_cdn('/img/mobile/wiki-logo.png'),
                'desc' => '方寸堂百科，专注于紫砂领域知识的创建与分享。',
            ]
        ]);
    }

    public function show(Request $request)
    {

        $typeId = intval($request->get('from_id', 0));
        $type = $request->get('from_type', '');
        if (!$typeId)
            return $this->autoReturn('ID不存在');
        if (!$type)
            return $this->autoReturn('百科类型不存在');

        try {

            $result = Wiki::getItem($typeId, $type);
            //获取分类
            if (!$request->ajax())
                $entities = Wiki::getFromTypes($type, $typeId);

        } catch (BusinessException $e) {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("获取成功", null, $result);

        $shareUrl = $this->myShareUrl(url('wiki/item', [], env('APP_SECURE')) . '?from_type='.$type.'&from_id='.$typeId);
        return view('wiki.show', [
            'title' => fct_title($result->name),
            'categories' => ProductCategory::getCategories(),
            'entities' => $entities,
            'entity' => $result,
            'fromType' => $type,
            'share' => [
                'title' => fct_title($result->name),
                'link' => $shareUrl,
                'img' => $result->image,
                'desc' => $result->intro,
            ]
        ]);
    }

}