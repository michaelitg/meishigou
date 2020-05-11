<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>OmiPay支付样例-订单查询</title>
    <link rel="icon" href="../favicon.ico">
    <!-- <link rel="stylesheet" href="../css/base.css"> -->
    <script>
        document.write('<link rel="stylesheet" href="../css/base.css?time='+new Date().getTime()+'">');
    </script>
</head>
<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

if (isset($_REQUEST["QRCode_id"]) && $_REQUEST["QRCode_id"] != "") {

    $qrcode_no = (trim($_REQUEST["QRCode_id"], " "));

    // ***订单查询***sdk从这里开始
    require_once "../lib/OmiPayApi.php";
    require_once "../common/Common.class.php";
    
    $input = new MakeScanOrderQueryData();
    
    $input->setMerchantNo(OmiPayConfig::merchant_no); 
    $input->setSercretKey(OmiPayConfig::merchant_key);

    $input->setNotifyUrl(OmiPayConfig::notify_url);// 这里是设置回调通知地址
    $input->setCurrency("AUD");         // 这里是设置币种，暂时只能传AUD，下一版本会支持CNY(人名币)
    $input->setOrderName("Test_Goods"); // 这里是设置商户名称
    $input->setAmount('1');             // 这里是设置支付金额   
    $time_no = OmiData::getMillisecondPublic();
    $out_order = OmiData::getNonceStrPublic(8);
    $input->setOutOrderNo($time_no.$out_order); // 这里是设置外部订单编号，请确保唯一性
    $input->setPOSNo('N9NL10195110'); // 商户 POS 端编码  N9NL10195110   /  17c7b5ece8104dc899f296cdfe917bd2
    $input->setQRCode($qrcode_no);  // 通过扫描得到的客户端二维码
    $result = OmiPayApi::scanOrder($input);  //调用接口，查询订单
    
    //  *****sdk结束
    Common::printf_info($result);

    exit();
}
?>
<body>
<form action="#" method="post" class="" >
    <h1 style="color:rgb(243, 37, 46);">QRCode No</h1>
    <br/>
    <input class="example_radius" type="text" placeholder="Please Input QRCode No" style="" name="QRCode_id"/>
    <div align="center">
        <input type="submit" value="Search"
               style="width:210px; height:50px; border-radius: 15px;background-color:#f97933; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;"
               type="button"/>
    </div>
</form>
</body>
</html>
