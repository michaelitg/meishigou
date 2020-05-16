<?php
require_once "lib/OmiPayApi.php";
require_once "common/Common.class.php";

class Mipay_BasicPayment_Model_Payment extends Mage_Payment_Model_Method_Abstract{
	// Code to match up with the groups node in default.xml
	protected $_code = "mipay_pay";
	// This is the block that's displayed on the checkout
	protected $_formBlockType = 'mipay_basicpayment/form_pay';
	// This is the block that's used to add information to the payment info in the admin and previous
	// order screens
	protected $_infoBlockType = 'mipay_basicpayment/info_pay';

    protected $_isInitializeNeeded      = true;
    protected $_canUseInternal          = true;
    protected $_canUseForMultishipping  = false;

    public function getRedirectUrl($_order){
        $type = "web";
        // 调用onile_order支付
        $input = new MakeOnlineOrderQueryData();
        $input->setMerchantNo(OmiPayConfig::merchant_no);
        $input->setSercretKey(OmiPayConfig::merchant_key);
        $input->setNotifyUrl(OmiPayConfig::notify_url); // 设置支付完成通知地址
        $input->setCurrency("AUD");     // 设置金额
        $input->setOrderName(urlencode("订单-".$_order->getIncrementId()));   // 设置产品名字
        $input->setAmount($_order->getGrandTotal()*100);         // 设置支付金额
        $input->setOutOrderNo($_order->getIncrementId());     // 设置外部订单编号
        $input->setPayType($type);        // 设置支付类型
        $input->setReturnUrl("http://www.meishigou.com.au/mipay/payment/response");           //  设置交易成功同步返回地址

        // 调用接口支付下单
        $result = OmiPayApi::onlineOrder($input);
        return $result['pay_url'];
    }

    public function getOrderPlaceRedirectUrl() {
        return Mage::getUrl('mipay/payment/redirect', array('_secure' => false));
    }
	
	// Use this to set whether the payment method should be available in only certain circumstances
	// This should only allow our payment method for over two items.
	public function isAvailable($quote = null){
		if(!$quote){
			return false;
		}
		
		//if($quote->getAllVisibleItems() <= 2){
		//	return false;
		//}
		
		return true;
	}
	
	// Errors are handled as a javascript alert on the client side
	// This method gets run twice - once on the quote payment object, once on the order payment object
	// To make sure the values come across from quote payment to order payment, use the config node sales_convert_quote_payment
    public function validate(){
       parent::validate();
	   
	   // This returns Mage_Sales_Model_Quote_Payment, or the Mage_Sales_Model_Order_Payment
       $info = $this->getInfoInstance();

       //$no = $info->getCheckNo();
       //$date = $info->getCheckDate();
	   
       //if(empty($no) || empty($date)){
       //    Mage::throwException($this->_getHelper()->__('Check No and Date are required fields'));
       //}

       return $this;
   }
	   
}