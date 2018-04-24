<?php

namespace App\Http\Controllers\Mobile;

use App\Discount;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

/**打折
 * Class DiscountController
 * @package App\Http\Controllers\Mobile
 */
class DiscountController extends BaseController
{

    public function show(Request $request, $id)
    {
        if ($id < 1)
            return $this->autoReturn("此促销活动不存在");
        try
        {
            $result = Discount::getDiscount($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('discount.show', [
            'title' => fct_title($result->name),
            'entity' => $result,
        ]);
    }
}
