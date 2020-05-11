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

if (isset($_REQUEST["order_id"]) && $_REQUEST["order_id"] != "") {
    $order_no = (trim($_REQUEST["order_id"], " "));

    
    // ***订单查询***sdk从这里开始
    require_once "../lib/OmiPayApi.php";
    require_once "../common/Common.class.php";
    $input = new QueryOrderQueryData();
    
    $input->setMerchantNo(OmiPayConfig::merchant_no); 
    $input->setSercretKey(OmiPayConfig::merchant_key);
    $input->setOrderNo($order_no);      // 订单编号Order No
    $result = OmiPayApi::orderQuery($input);  //调用接口，查询订单

    // 打印结果
    Common::printf_info($result);  
    //  *****sdk结束

    exit();
}
?>
<body>
<form action="#" method="post" class="" >
    <h1 style="color:rgb(243, 37, 46);">Order No</h1>
    <br/>
    <input onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" class="example_radius" type="text" placeholder="Please Input Order No" style="" name="order_id"/>
    <div align="center">
        <input type="submit" value="Search"
               style="width:210px; height:50px; border-radius: 15px;background-color:#f97933; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;"
               type="button"/>
    </div>
</form>
</body>
</html>