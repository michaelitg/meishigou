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
$get_content = file_get_contents("php://input");
$response = "";
$response = json_decode($get_content, true);  // 加上true就是强制性转换成关联数组

if($response){
    $content = json_encode($response); 
    Log::INFO($content);

    if(!isset($response["token_id"])){
        echo json_encode(array('return_code' => 'FAIL'));
        exit;
    }else{
        $result1 = array('return_code' => 'SUCCESS');
        echo json_encode($result1);
    }
    
    $input = new OmiData();
    
    $input->setMerchantNo(OmiPayConfig::merchant_no); 
    $input->setSercretKey(OmiPayConfig::merchant_key); 
    $input->setTokenId($response["token_id"]);

    $result = OmiPayApi::checkout($input);

    if ($result) {   //验证成功
        $content1 = json_encode($result);
        Log::INFO($content1);
    }

}else{
    exit;
}





?>