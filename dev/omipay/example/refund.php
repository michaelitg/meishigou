<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<title>OmiPay支付样例-退款</title>
	<link rel="icon" href="../favicon.ico">
	<!-- <link rel="stylesheet" href="../css/base.css">-->
	<script>
        document.write('<link rel="stylesheet" href="../css/base.css?time='+new Date().getTime()+'">');
    </script>
</head>
<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
header("Content-Type:text/html;charset=utf-8");

if(isset($_REQUEST["order_id"]) && $_REQUEST["order_id"] != "" && isset($_REQUEST["refund_id"]) && $_REQUEST["refund_id"] != ""){
	if (!isset($_REQUEST["amount"]) || $_REQUEST["amount"] == ""){
		echo '请输入退款金额';
		exit();
	}
	$amount = (trim($_REQUEST["amount"], " ")) * 100;
	// $orderId = $_REQUEST["order_id"];
	// $refundId = $_REQUEST["refund_id"];

	$orderId = (trim($_REQUEST["order_id"], " "));
	$refundId = (trim($_REQUEST["refund_id"], " "));	

	// *****发起退款***SDK从这里开始
	require_once "../lib/OmiPayApi.php";
	require_once "../common/Common.class.php";

	$input = new RefundQueryData();   
	
	$input->setMerchantNo(OmiPayConfig::merchant_no); 
	$input->setSercretKey(OmiPayConfig::merchant_key);

	$input->setOrderNo($orderId);			// 订单编号Order No
	$input->setOutRefundNo($refundId);		// 外部订单编号Platform Order No
	$input->setAmount(intval($amount));		// 退款金额
	$result = OmiPayApi::refund($input);  // 调用接口，发起退款

	// 打印结果
	Common::printf_info($result); 
	exit();
}
?>
<body>  
	<form action="#" method="post">
        <h2 class="title" style="margin-left:2%;">Order No</h2>
        <input onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" type="text" class="example_radius" placeholder="Please Input Order No" name="order_id" />
		<h2 class="title" style="margin-left:2%;">Out Refund No</h2>
		<input onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" class="example_radius" type="text" placeholder="Please Input Out Refund No" name="refund_id" />
        <h2 class="title" style="margin-left:2%;">Amount(AUD)</h2>
        <input onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" class="example_radius" type="text" placeholder="Please Input Refund Amount" name="amount" />
		<div align="center">
			<input type="submit" value="Submit" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" />
		</div>
	</form>
</body>
</html>