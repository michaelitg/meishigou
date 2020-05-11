<!DOCTYPE html>
<!-- saved from url=(0049)http://www.omipay.com.cn/developing.html/http://www.omipay.com.au/developing.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Test Goods</title>
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" type="text/css" href="./css/weui.min.css">
    <link rel="icon" href="favicon.ico">
    <script type="text/javascript">
        function get_val(name){
            var ele = document.getElementById(name);
            return ele?parseInt(ele.value):null;
        }
        function micropay() {
            var payCode = document.getElementById('paycodeinput').value;
            if (!payCode) {
                alert('Input Order No first');
                return;
            }
            location.href = 'example/orderquery.php?order_no=' + payCode;
        }

        function refund(){
            var payCode = document.getElementById('paycodeinput_refund').value;
            if (!payCode) {
                alert('Input Refund No first');
                return;
            }
            location.href = 'example/refundquery.php?refund_no=' + payCode;
        }

        function qrpay(){
            var platform_value = get_val('platform_select');
            var platform = "WECHATPAY";
            if(platform_value === 1){
                platform = "ALIPAY";
            }else if(platform_value === 2){
                platform = "UPI"; // 银联支付
            }
            location.href = 'example/qr.php?platform=' + platform;
        }

        function getRate(){
            var platform_value = get_val('platform_rate');
            var platform = "WECHATPAY";
            if(platform_value === 1){
                platform = "ALIPAY";
                
            }
            location.href = 'example/exchange_rate.php?platform=' + platform;
        }

        function getOnlineOrder(){
            var platform_value = get_val('type_select');
            var platform = "web";
            if(platform_value === 1){
                platform = "wap";
            }
            location.href = 'example/online_order.php?type=' + platform;
        }
        function getAPIPay(){
            var platform_value = document.getElementById('direct').value;
            var platform = "no";
            if(platform_value == 1){
                platform = "yes";
            }
            location.href = 'example/jsApi.php?type=' + platform;
        }

    
    </script>
    <style type="text/css">
        body {
            background: rgba(249, 146, 101,.7);
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            overflow: auto;
            padding-top: 50px;
            color: #fff;
        }

        h1, h3 {
            width: 100%;
            text-align: center;
        }

        h1 {
            color: rgb(198, 23, 31);
        }

        .ui-container {
            display: block;
            margin: auto;
            width: 100%;
            max-width: 800px;
        }

        .btn-row{
            display: block;
            width: 100%;
            margin: 10px 0;
        }

        .btn-row:after{
            content:'';
            display: block;
            clear: both;
        }

        .btn-row a{
            background: #fff;
            color: #000;
            height: 60px;
            font-size: 24px;
            line-height: 60px;
            border-radius: 30px;
            text-align: center;
            margin: 0 -1px;
            padding: 0;
            border: 1px solid #fff;
            width: 100%;
            display: block;
            float: left;
            cursor: pointer;
        }
        .btn-row a:hover,.btn-row a:active{
            background: rgba(198, 23, 31,.5);
            color: #fff;
        }
        
        .btn-row.retail input,.btn-row.retail a, .btn-row.retail select{
            width: 50%;
        }
        .btn-row.retail a{
            border-radius: 0 30px 30px 0;
        }
        .btn-row.retail input, .btn-row.retail select{
            height: 60px;
            font-size: 24px;
            line-height: 60px;
            border-radius: 30px 0 0 30px;
            text-indent: 30%;
            margin: 0 -1px;
            padding: 0;
            border: 1px solid #fff;
            color: #fff;
            background: rgba(249, 146, 101,.7);
            display: block;
            float: left;
            text-align: center;
        }
        .btn-row.retail select{
            box-sizing: content-box;
        }

        .btn-row a .major,.btn-row.retail input .major{
            font-size: 18px;
            line-height: 40px;
            display: block;
            width: 100%;
        }

        .btn-row a .subtitle,.btn-row.retail input .subtitle{
            font-size: 12px;
            line-height: 20px;
            display: block;
            width: 100%;
            color: #333333;
        }

        @media (max-width: 800px) {
            .ui-container{
                width: 90%;
            }

            .btn-row.retail input, .btn-row.retail select, .btn-row.retail a{
                width: 100%;
            }

            .btn-row.retail input, .btn-row.retail select{
                border-radius: 30px 30px 0 0;
            }

            .btn-row.retail a{
                border-radius: 0 0 30px 30px;
            }
        }
    </style>
</head>
<body>
<h1>Test Goods</h1>
<h3>Price: AUD 0.01</h3>
<div class="ui-container">
    <div class="btn-row retail">
        <select class="weui_input" name="" id="platform_rate" value="" >
            <?php 
                //判断是不是微信
                if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {  
                    // $value = 'WECHATPAY';
                    echo '<option value="0">WECHATPAY</option>';
                }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
                    // $value = 'ALIPAY';
                    echo '<option value="1">ALIPAY</option>';
                }else{
                    echo '<option value="0">WECHATPAY</option>
                    <option value="1">ALIPAY</option>';
                }
            ?>
        </select>
        <a onclick="getRate();">
            <span class="major">Exchange Rate</span>
            <span class="subtitle">Get The Current Exchange Rate</span>
        </a>
    </div>
    <div class="btn-row retail">
        <select class="weui_input" name="" id="platform_select" value="" style="">
            <?php 
                //判断是不是微信
                if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {  
                    // $value = 'WECHATPAY';
                    echo '<option value="0">WECHATPAY</option>';
                }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
                    // $value = 'ALIPAY';
                    echo '<option value="1">ALIPAY</option>';
                }else{
                    echo '<option value="0">WECHATPAY</option>
                    <option value="1">ALIPAY</option>
                    <option value="2">UNIONPAY</option>'; 
                }
            ?>
        </select>
        <a onclick="qrpay();">
            <span class="major">QR Pay</span>
            <span class="subtitle">For PC Website</span>
        </a>
        
    </div>
    <div class="btn-row retail">
        <select class="weui_input" name="" id="type_select" value="" >
            <option value="0">WEB</option>
            <option value="1">WAP</option>
        </select>
        <a onclick="getOnlineOrder();">
            <span class="major">Onlie Order</span>
            <span class="subtitle">OmiPay Order</span>
        </a>
    </div>
    <div class="btn-row retail">
        <select class="weui_input" name="" id="direct" value="" >
            <option value="0">Not Direct</option>
            <option value="1">Direct</option>
        </select>
        <a onclick="getAPIPay();">
            <span class="major">Pay with OmiPay API Pay</span>
            <span class="subtitle">For APP(Wechat/Alipay)</span>
        </a>
    </div>
    <div class="btn-row">
        <a href="example/card_pay.php">
            <span class="major">Card Pay</span>
            <span class="subtitle">OmiPay CardPay</span>
        </a>
    </div>

    <!-- ScanOrder -->

    <div class="btn-row">
        <a href="example/scan.php">
            <span class="major">Scan Order</span>
            <span class="subtitle">OmiPay Order</span>
        </a>
    </div>

    <div class="btn-row">
        <a href="example/orderquery.php">
            <span class="major">Order Tracking</span>
            <span class="subtitle">OmiPay Order</span>
        </a>
    </div>
    <div class="btn-row">
        <a href="example/refundquery.php">
            <span class="major">Refund Tracking</span>
            <span class="subtitle">OmiPay Refund Check</span>
        </a>
    </div>
    <div class="btn-row">
        <a href="example/refund.php">
            <span class="major">Refund</span>
            <span class="subtitle">OmiPay Refund</span>
        </a>
    </div>
    
</div>

</body></html>