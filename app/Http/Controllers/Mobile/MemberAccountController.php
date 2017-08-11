<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-22
 * Time: 下午3:41
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\MemberAccount;
use Illuminate\Http\Request;

class MemberAccountController extends BaseController
{

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        try
        {
            $result = MemberAccount::getLogs($page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        return view('account.index', [
            'title' => fct_title('帐户明细'),
            'logs' => $result,
        ]);
    }

    public function wallet(Request $request)
    {
        try
        {
            $result = MemberAccount::getAccount();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('account.wallet', [
            'title' => fct_title('我的钱包'),
            'account' => $result,
        ]);
    }
}