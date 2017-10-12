<?php

/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-14
 * Time: 上午9:23
 */
namespace App\Http\Controllers\PC;



use App\Exceptions\BusinessException;
use App\Main;

class MainController extends BaseController
{

    public function index()
    {
        try
        {
            $result = Main::getPcHome();
        }
        catch (BusinessException $e)
        {
        }

        $result['title'] = '方寸堂';
        $result['qrcodeUrl'] = 'http://qr.topscan.com/api.php?text=';
        $result['qrcodeUrl'] = 'https://pan.baidu.com/share/qrcode?w=300&h=300&url=';

        return view('pc.index', $result);
    }

}