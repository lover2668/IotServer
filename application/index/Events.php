<?php
/**
 * Created by PhpStorm.
 * User: taowenyin
 * Date: 18-1-1
 * Time: 上午7:36
 */

use GatewayWorker\Lib\Gateway;

class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        Gateway::sendToClient($client_id, json_encode(array(
            'type' => 'onConnect',
            'client_id' => $client_id
        )));

//        // 向当前client_id发送数据
//        Gateway::sendToClient($client_id, "Hello $client_id");
//
//        // 向所有人发送
//        Gateway::sendToAll("$client_id login");
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param string $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        // 向所有人发送
        Gateway::sendToAll("$client_id said $message");
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        // 向所有人发送
        GateWay::sendToAll("$client_id logout");
    }
}