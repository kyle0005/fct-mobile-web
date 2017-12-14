<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-12-11
 * Time: 下午1:31
 */

namespace App;


use App\Exceptions\BusinessException;

class MemberStore
{
    public static function saveStore($code, $name, $remark) {
        $result = Base::http(
            env('API_URL') . '/member/apply-store',
            [
                'code' => $code,
                'name' => $name,
                'remark' => $remark,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        return $result->data;
    }
}