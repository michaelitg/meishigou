<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>OmiPay支付样例-汇率查询</title>
    <link rel="icon" href="../favicon.ico">
    <!-- <link rel="stylesheet" href="../css/base.css"> -->
    <script>
        document.write('<link rel="stylesheet" href="../css/base.css?time='+new Date().getTime()+'">');
    </script>
</head>
<body>
<?php
ini_set('date.timezone', 'Asia/Shanghai');

if(isset($_GET['platform']) && $_GET['platform'] != ''){
    $plat = $_GET['platform'];
}else{
    exit(json_encode(array("FAIL"=>"parameter is not correct")));
}

// **获取汇率**从这里开始引入sdk
require_once "../lib/OmiPayApi.php";
require_once "../common/Common.class.php";

$input = new OmiPayExchangeRate();

$input->setMerchantNo(OmiPayConfig::merchant_no); 
$input->setSercretKey(OmiPayConfig::merchant_key);
$input->setPlatform($plat); // 设置查询平台"WECHATPAY/ALIPAY"
$result = OmiPayApi::exchangeRate($input);

// 页面输出$result
Common::printf_info($result);

// *****这里结束
exit();
?>
</body>
</html>