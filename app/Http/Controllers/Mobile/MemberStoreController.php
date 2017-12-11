<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-12-11
 * Time: 下午1:40
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\MemberStore;
use Illuminate\Http\Request;

class MemberStoreController extends BaseController
{
    public function create(Request $request)
    {
        return view('store.form', [
            'title' => fct_title('申请开店'),
        ]);
    }

    public function store(Request $request)
    {
        $code = $request->get('code', '');
        $name = $request->get('name', '');
        $remark = $request->get('remark', '');

        try
        {
            MemberStore::saveStore($code, $name, $remark);
            return $this->returnAjaxSuccess('申请店铺成功，请耐心等待审核。',
                url('/', [], env('APP_SECURE')));
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }
}