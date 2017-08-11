<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\MemberAddress;
use Illuminate\Http\Request;

/**用户收货地址管理
 * Class MemberAddressController
 * @package App\Http\Controllers\Mobile
 */
class MemberAddressController extends BaseController
{
    public function index(Request $request)
    {
        try
        {
            $result = MemberAddress::getAddresses();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('address.index', [
            'title' => fct_title('地址管理'),
            'addressList' => $result
        ]);
    }

    public function create(Request $request)
    {
        $result = [
            'title' => fct_title('新建收货地址'),
            'address' => json_encode((object)[]),
        ];

        $this->cacheRedirectSourceUrl('', true);

        return view('address.form', $result);
    }

    public function edit(Request $request)
    {
        $id = $request->get('id', 0);
        try
        {
            $result = MemberAddress::getAddress($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('address.form', $result);
    }

    public function store(Request $request)
    {
        $id = intval($request->get('id', 0));
        $name = $request->get('name');
        $phone = $request->get('cellPhone');
        $province = $request->get('province');
        $city = $request->get('city');
        $region = $request->get('county');
        $address = $request->get('address');
        $isDefault = $request->get('isDefault', 0) ? 1 : 0;

        try
        {
            MemberAddress::saveAddress($id, $name, $phone, $province, $city, $region, $address, $isDefault);

            $redirectUrl = $this->getRedirectSourceUrl(true, false);
            if (!$redirectUrl) {
                $redirectUrl = url('my/address');
            }

            return $this->returnAjaxSuccess(($id ? '修改' : '添加') . '成功', $redirectUrl);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

    }

    public function setDefault(Request $request)
    {
        $id = intval($request->get('id', 0));

        try
        {
            MemberAddress::setDefault($id);

            $redirectUrl = $this->getRedirectSourceUrl(true, false);
            if (!$redirectUrl) {
                $redirectUrl = url('my/address');
            }

            return $this->returnAjaxSuccess('设置默认成功', $redirectUrl);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function setDelete(Request $request)
    {
        $id = intval($request->get('id', 0));
        try
        {
            MemberAddress::setDelete($id);
            return $this->returnAjaxSuccess('删除成功');
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function choose(Request $request)
    {
        try
        {
            $result = MemberAddress::getAddresses();
            $this->cacheRedirectSourceUrl('', true);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('address.choose', [
            'title' => fct_title('选择收货地址'),
            'addressList' => $result,
        ]);
    }
}
