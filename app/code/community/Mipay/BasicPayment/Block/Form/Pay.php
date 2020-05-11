<?php 
class Mipay_BasicPayment_Block_Form_Pay extends Mage_Core_Block_Template{
	protected function _construct(){
		parent::_construct();
		
		$this->setTemplate('mipay/basicpayment/form/pay.phtml');
	}
}