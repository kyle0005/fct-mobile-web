<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-7-27
 * Time: 下午1:35
 */

namespace App\Http\Controllers\PC;


class THRController extends BaseController
{

    public function getSlider() {
        return $this->returnAjaxSuccess('获取滚动列表', '', [
            [
                'image' => fct_cdn('/img/fct/thr/sw1.jpg'),
                'url' => 'javascript:;'
            ],
            [
                'image' => fct_cdn('/img/fct/thr/sw2.jpg'),
                'url' => 'javascript:;'
            ],
            [
                'image' => fct_cdn('/img/fct/thr/sw3.jpg'),
                'url' => 'javascript:;'
            ],
            [
                'image' => fct_cdn('/img/fct/thr/sw4.jpg'),
                'url' => 'javascript:;'
            ],
        ]);
    }
}
