<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');

header('Content-type:text/json;charset="utf-8"');

ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);
require_once "../lib/OmiPayApi.php";
require_once "../lib/OmiPayData.php";

//回调参数读取
Log::INFO("收到通知:");
// $response = json_decode($GLOBALS['HTTP_RAW_POST_DATA'], true); // 强制转换成关联数组
$get_content = file_get_contents("php://input");
var_dump($get_content);
$response = "";
parse_str($get_content, $response);
// $response = json_decode($get_content, true);  // 加上true就是强制性转换成关联数组
if($response){
    Log::WARN( json_encode($response) );
}

$input = new OmiData();

$input->setMerchantNo(OmiPayConfig::merchant_no); 
$input->setSercretKey(OmiPayConfig::merchant_key);

$input->setTime($response['timestamp']);
$input->setNonceStr($response['nonce_str']);
$input->setSign();

if ($input->getSign() == $response['sign']) {   //验证成功
    Log::WARN( json_encode($response) );

    // //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    $result = array('return_code' => 'SUCCESS');
    echo json_encode($result);exit;
} else {//验证失败
    echo json_encode(array('return_code' => 'FAIL'));exit;
}
?>