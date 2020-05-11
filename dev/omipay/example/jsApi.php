
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>O米支付</title>
    <link rel="icon" href="../favicon.ico">
    <!-- <link rel="stylesheet" href="../css/base.css?t=12312"> -->
    <script>
        document.write('<link rel="stylesheet" href="../css/base.css?time='+new Date().getTime()+'">');
    </script>
    
</head>
<body>

<?php

ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

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
$input->setAmount('1');         // 设置支付金额
$input->setOutOrderNo($time_no.$out_order);  

// $input->setONumber("04");  // 门店编号
// $input->setPOSNo("");   // （非必传）指定下单的POS机编号

$input->setPcPay("1");        //  show_pc_pay_url=1

if(isset($_GET['type']) && $_GET['type'] == 'yes'){
    $input->setDirectPay('1');    //设置是否直接支付 是则设置为1
}

$currency = $input->getCurrency();

// 调用接口支付下单
$result = OmiPayApi::jsApiOrder($input);

Common::printf_info($result);

$inputObj = new OmiPayRedirect();
$inputObj->setMerchantNo(OmiPayConfig::merchant_no); 
$inputObj->setSercretKey(OmiPayConfig::merchant_key);

$jump = OmiPayApi::getQRRedirectUrl($result['pc_pay_url'], $inputObj); // 这个是跳转到omipay网页扫码支付，要加上签名验证
$jump .= "&redirect_url=https://www.omipay.com.cn";   // 支付完成之后跳转地址

$link = $result['pay_url']; // 接口SUCCESS返回的pay_url就是支付地址, 需要再支付宝或者微信中打开

// ******sdk到这里就结束了
Common::create_qrcode('支付宝/微信 扫码', $link, $jump);

$isMobile = OmiPayApi::isMobile();

if ( ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false ) && $isMobile === true) {          
    exit('<script language="javascript" type="text/javascript">
    window.location.href="'.$link.'"; 
    </script>') ;
}

?>
</body>
</html>
