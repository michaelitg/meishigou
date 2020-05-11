
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>O米支付</title>
    <link rel="icon" href="../favicon.ico">
    <!-- <link rel="stylesheet" href="../css/base.css"> -->
    <script>
        document.write('<link rel="stylesheet" href="../css/base.css?time='+new Date().getTime()+'">');
    </script>
</head>
<body>

<?php

ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

header("Content-Type:text/html;charset=utf-8");

// **调用jsapi支付**sdk从这里开始
require_once "../lib/OmiPayApi.php";
require_once "../common/Common.class.php";

// 调用jsapi支付
$input = new MakeJSAPIOrderQueryData();
$time_no = OmiData::getMillisecondPublic();  // 获取毫秒的时间戳
$out_order = OmiData::getNonceStrPublic(8);  // 获得8位随机字符串， 时间戳+8位随机字符可生成外部订单号

$input->setMerchantNo(OmiPayConfig::merchant_no); 
$input->setSercretKey(OmiPayConfig::merchant_key);
$input->setNotifyUrl(OmiPayConfig::notify_url); // 设置支付完成通知地址
$input->setCurrency("AUD");     // 设置金额
$input->setOrderName(urlencode("test goods"));   // 设置产品名字
$input->setAmount('100');          // 设置支付金额
$input->setOutOrderNo($time_no.$out_order);     // 设置外部订单编号
$input->setRedirectUrl("http://www.omipay.com.cn");


$currency = $input->getCurrency();

// 调用接口支付下单
$result = OmiPayApi::jsApiOrder($input);

$link = $result['pay_url']; // 接口SUCCESS返回的pay_url就是支付地址

$arr_link = parse_url($link);
// var_dump($arr_link["query"]);

$get_arr = [];
parse_str($arr_link["query"], $get_arr);

if(isset($get_arr["organizationId"]) && isset($get_arr["transId"])){
    $qr_pay_url = OmiPayConfig::IpayLinksUrl . "qr_pay.html?state=ORG" . $get_arr["organizationId"];
    $api_pay_url = OmiPayConfig::IpayLinksUrl . "api_pay.html?state=TRN" . $get_arr["transId"];
    Common::create_qrcode("卡支付门店固定二维码", $qr_pay_url, $qr_pay_url);
    Common::create_qrcode("API二维码", $api_pay_url, $api_pay_url);
}

?>
</body>
</html>
