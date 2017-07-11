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

        return view('address.index', $result);
    }

    public function create(Request $request)
    {
        $result = [
            'title' => '新建收货地址',
            'address' => json_encode([]),
        ];

        return view('address.form', $result);
    }

    public function edit(Request $request, $id)
    {
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
        $id = $request->get('id', 0);
        $name = $request->get('name');
        $phone = $request->get('phone');
        $province = $request->get('province');
        $city = $request->get('city');
        $region = $request->get('region');
        $address = $request->get('address');
        $isDefault = $request->get('is_default', 0);

        try
        {
            MemberAddress::saveAddress($id, $name, $phone, $province, $city, $region, $address, $isDefault);
            return $this->returnAjaxSuccess(($id ? '修改' : '添加') . '成功');
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

    }

    public function setDefault(Request $request, $id)
    {
        try
        {
            MemberAddress::setDefault($id);
            return $this->returnAjaxSuccess('设置默认成功');
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function setDelete(Request $request, $id)
    {
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

}
