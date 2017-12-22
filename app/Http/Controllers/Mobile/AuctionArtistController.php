<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 17-12-22
 * Time: 下午5:21
 */

namespace App\Http\Controllers\Mobile;


use App\Artist;
use Illuminate\Http\Request;


class AuctionArtistController extends BaseController
{

    public function show(Request $request, $id) {

        try
        {
            $result = Artist::getArtistAndProducts($id, 0);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('auction.artist.show', [
            'title' => fct_title($result->name .'制作人'),
            'entity' => $result,
        ]);
    }

}