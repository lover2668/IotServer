<?php
namespace app\index\controller;

use GatewayClient\Gateway;
use think\Controller;
use think\Request;
use think\Session;

class Index extends Controller
{
    public static $webSocketGroup = 3;

    public function index()
    {
        if (!Session::has('uid')) {
            Session::set('uid', uuid());
        }

        return $this->fetch();
    }

    public function iot()
    {
        return $this->fetch();
    }

    public function bindConnect()
    {
        $res = [
            'res' => 'error'
        ];

        if (!Request::instance()->isPost()) {
            $res['msg'] = '数据提交方式操作';
        } else {
            $client_id = Request::instance()->post('client_id');
            $uid = Request::instance()->session('uid');
            $group_id = self::$webSocketGroup;

            $res['res'] = 'success';
            $res['client_id'] = $client_id;
            $res['uid'] = $uid;

            // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
            Gateway::$registerAddress = '127.0.0.1:1236';

            // client_id与uid绑定
            Gateway::bindUid($client_id, $uid);

            // 加入某个群组（可调用多次加入多个群组）
            Gateway::joinGroup($client_id, $group_id);
        }

        return $res;
    }

    public function toggleIot()
    {
        $res = [
            'res' => 'error'
        ];

        if (!Request::instance()->isPost()) {
            $res['msg'] = '数据提交方式操作';
        } else {
            $res['res'] = 'success';

            $client_id = Request::instance()->post('client_id');
            $iot_toggle = Request::instance()->post('iot_toggle');

            if($iot_toggle == 1) {
                Gateway::sendToGroup(2, "LED_ON");
            } else {
                Gateway::sendToGroup(2, "LED_OFF");
            }


//            Gateway::sendToAll("Hello IOT");
        }

        return $res;
    }

    public function closeConnect()
    {
        $res = [
            'res' => 'error'
        ];

        if (!Request::instance()->isPost()) {
            $res['msg'] = '数据提交方式操作';
        } else {
            $res['res'] = 'success';

            $client_id = Request::instance()->post('client_id');

            Gateway::closeClient($client_id);

        }

        return $res;
    }
}
