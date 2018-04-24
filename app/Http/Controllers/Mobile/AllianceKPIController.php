<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午10:07
 */

namespace App\Http\Controllers\Mobile;


use App\AllianceKPI;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class AllianceKPIController extends BaseController
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        try
        {
            $result = AllianceKPI::find($page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        return view('alliance.kpi.index', [
            'title' => fct_title('考核列表'),
            'kpis' => $result,
        ]);
    }

}