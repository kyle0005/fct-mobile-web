<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-1-5
 * Time: 下午3:05
 */

namespace App\Http\Controllers\Mobile;


use Illuminate\Http\Request;

class LiveController extends BaseController
{

    public function show(Request $request)
    {
        $liveId = $request->get('live_id', '');
        if (!$liveId) {
            return $this->autoReturn('无此直播');
        }

        return view('live.show', [
            'title' => fct_title('直播'),
            'liveId' => $liveId,
            'appId' => '1253930304',
        ]);
    }

}