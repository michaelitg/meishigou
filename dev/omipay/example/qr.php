

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>OmiPay支付样例-扫码</title>
    <link rel="icon" href="../favicon.ico">
    <!-- <link rel="stylesheet" href="../css/base.css"> -->
    <script>
        document.write('<link rel="stylesheet" href="../css/base.css?time='+new Date().getTime()+'">');
        function redirect(url) {
            window.location.href = url;
        }
    </script>
</head>
<body>
<?php
ini_set('date.timezone', 'Asia/Shanghai');
header("Content-Type:text/html;charset=utf-8");

// *********sdk 从这里开始
require_once "../lib/OmiPayApi.php";
require_once "../common/Common.class.php";

// *****这个if语句是不需要的
if(isset($_GET['platform']) && $_GET['platform'] != ''){
    $plat = $_GET['platform'];
}else{
    exit(json_encode(array("FAIL"=>"parameter is not correct")));
}

//获取扫码
$input = new MakeOrderQueryData();

$input->setMerchantNo(OmiPayConfig::merchant_no); 
$input->setSercretKey(OmiPayConfig::merchant_key);

$input->setPlatform($plat); // $input->setPlatform("WECHATPAY/ALIPAY");
$time_no = OmiData::getMillisecondPublic();
$out_order = OmiData::getNonceStrPublic(8);
$input->setNotifyUrl(OmiPayConfig::notify_url);// 这里是设置回调通知地址
$input->setCurrency("AUD");         // 这里是设置币种，暂时只能传AUD，下一版本会支持CNY(人名币)
$input->setOrderName("Test_Goods"); // 这里是设置商户名称
$input->setAmount('1');             // 这里是设置支付金额   
$input->setOutOrderNo($time_no.$out_order); // 这里是设置外部订单编号，请确保唯一性

// 这里是调用接口的返回结果
$result = OmiPayApi::qrOrder($input);

// ******sdk到这里就结束

Common::printf_info($result);

$inputObj = new OmiPayRedirect();
$inputObj->setMerchantNo(OmiPayConfig::merchant_no); 
$inputObj->setSercretKey(OmiPayConfig::merchant_key);

$isMobile = OmiPayApi::isMobile();

if($plat === 'WECHATPAY'){
    $longPress = '微信扫码';
}else if($plat === 'ALIPAY'){
    $longPress = '支付宝扫码';
}else if($plat === 'UPI'){
    $longPress = '银联扫码';
}else{
    $longPress = 'OmiPay扫码';
}

if($isMobile === true){
    //判断是不是微信
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {  
        $longPress = '微信扫码';
    }else if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
        $longPress = '支付宝扫码';
    }
}

if(isset($result["qrcode"]) && $result["qrcode"] != '' && isset($result['pay_url'])){
    $jump = OmiPayApi::getQRRedirectUrl($result['pay_url'], $inputObj); // 这个是跳转到omipay网页扫码支付，要加上签名验证
    $jump .= '&redirect_url=https://www.omipay.com.cn'; // 这里为支付完成之后跳转地址

    Common::create_qrcode($longPress, $result["qrcode"], $jump);
}

?>


<script type="text/javascript">
    setTimeout(function() {
        window.location.reload();
    }, 180000);
</script>
</body>
</html>