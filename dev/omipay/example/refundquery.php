<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>OmiPay支付样例-查退款单</title>
    <link rel="icon" href="../favicon.ico">
    <!-- <link rel="stylesheet" href="../css/base.css"> -->
    <script>
        document.write('<link rel="stylesheet" href="../css/base.css?time='+new Date().getTime()+'">');
    </script>
</head>
<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

if (isset($_REQUEST["refund_id"]) && $_REQUEST["refund_id"] != "") {
    $refundId = (trim($_REQUEST["refund_id"], " "));

    // ***退款单号查询SDK从这里开始***
    require_once "../lib/OmiPayApi.php";
    require_once "../common/Common.class.php";

    $input = new QueryRefundQueryData();

    $input->setMerchantNo(OmiPayConfig::merchant_no); 
    $input->setSercretKey(OmiPayConfig::merchant_key);

    $input->setRefundNo($refundId);         // 设置退款单编号  Refund No
    $result = OmiPayApi::refundQuery($input); // 这里是接口调用查询

    // 打印结果
    Common::printf_info($result);   
    exit();
}

?>
<body>
<form action="#" method="post">
    <h1 style="color:rgb(243, 37, 46);">Refund No</h1>
    <br/>
    <input onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" class="example_radius" type="text" placeholder="Please Input Refund No" style="" name="refund_id"/>
    <div align="center">
        <input type="submit" value="Search"
               style="width:210px; height:50px; border-radius: 15px;background-color:#f97933; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;"
               type="button"/>
    </div>
</form>
</body>
</html>