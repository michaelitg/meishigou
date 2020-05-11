
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

if(isset($_GET['type']) && $_GET['type'] != ''){
    $type = $_GET['type'];
}else{
    exit(json_encode(array("FAIL"=>"type is not correct")));
}

// 调用onile_order支付
$input = new MakeOnlineOrderQueryData();
$time_no = OmiData::getMillisecondPublic();  // 获取毫秒的时间戳
$out_order = OmiData::getNonceStrPublic(8);  // 获得8位随机字符串， 时间戳+8位随机字符可生成外部订单号

$input->setMerchantNo(OmiPayConfig::merchant_no); 
$input->setSercretKey(OmiPayConfig::merchant_key);

$input->setNotifyUrl(OmiPayConfig::notify_url); // 设置支付完成通知地址
$input->setCurrency("AUD");     // 设置金额
$input->setOrderName(urlencode("测试订单"));   // 设置产品名字
$input->setAmount('1');         // 设置支付金额
$input->setOutOrderNo($time_no.$out_order);     // 设置外部订单编号
$input->setPayType($type);        // 设置支付类型
$input->setReturnUrl("https://www.omipay.com.cn");           //  设置交易成功同步返回地址

// 调用接口支付下单
$result = OmiPayApi::onlineOrder($input);

// 页面输出结果
Common::printf_info($result);

echo '<div style="margin-left: 10%;color:#556B2F;font-size:30px;font-weight: bolder;">一、跳转到OmiPay支付(pay_url)</div>
    <br/><a class="jump" style="display:block; width:210px; height:50px; text-align:center; line-height: 50px;margin: 50px auto; border-radius: 15px;background-color:#f97933; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" href="'.$result['pay_url'].'">跳转
    </a>';

// ******sdk到这里就结束了


?>
</body>
</html>
