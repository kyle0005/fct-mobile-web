<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

/**大师
 * Class ArtistController
 * @package App\Http\Controllers\Mobile
 */
class ArtistController extends BaseController
{
    /**大师首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('artist.index');
    }

    /**大师详情
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        return view('artist.show');
    }
}
