<?php

use Apple\ApnPush\Certificate\Certificate;
use Apple\ApnPush\Notification;
use Apple\ApnPush\Notification\Connection;


require realpath(__DIR__ . '/../vendor/autoload.php');

$app = new Slim\Slim();

$app->response()->headers->set('Access-Control-Allow-Headers', 'Content-Type');
$app->response()->headers->set('Access-Control-Allow-Methods', 'GET, POST');
$app->response()->headers->set('Access-Control-Allow-Origin', '*');
$app->response->header('charset', 'utf-8');


$app->get('/apple/push',function() use ($app){
    $pemFilePath = realpath('../certificate/certificate.pem');
    $app->response->headers->set('Content-Type', 'application/json');
    try{
        $certificate = new Certificate($pemFilePath, '');
        $connection = new Connection($certificate, false); // if not sandbox make the second parameter true
        $notification = new Notification($connection);
        $resultMsg =  $notification->sendMessage('3c22c4f4a0a1981352975becb475d0d39bc1611bb9fe502de7dba14eddf82455', 'ذلك. لفشل الأثنان');
        $result = [
            "status" => "success",
            "message" => json_decode($resultMsg)
        ];
    }catch(Exception $error){
        $result = [
            "status" => "error",
            "message" => $error->getMessage()
        ];
    }
    echo json_encode($result);
});

$app->get('/apple/push',function() use ($app){
    echo "hello";
});

?>