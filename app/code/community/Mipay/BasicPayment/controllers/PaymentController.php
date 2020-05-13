<?php
/*
Mygateway Payment Controller
By: Junaid Bhura
www.junaidbhura.com
*/

class Mipay_BasicPayment_PaymentController extends Mage_Core_Controller_Front_Action {
    public function indexAction(){
        $this->getResponse()->setBody("Mipay!");
    }
	// The redirect action is triggered when someone places an order
	public function redirectAction() {
		$this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template','mipay_redirect',array('template' => 'mipay/basicpayment/form/redirect.phtml'));
		$this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
	}
	
	// The response action is triggered when your gateway sends back a response after processing the customer's payment
	public function responseAction() {
        Mage::log('-----------mipay get response-----------------------');
        $data = $this->getRequest()->getParams();
        Mage::log($data);
		$validated = true; //check if the payment is ok from alipay
		if($validated) {
            $order = Mage::getModel('sales/order')->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
            if ($order->getId()) {
                $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'OMipay has authorized the payment.');
                $order->sendNewOrderEmail();
                $order->setEmailSent(true);
                $order->save();
                Mage::getSingleton('checkout/session')->unsQuoteId();
                Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/success', array('_secure' => true));
                return;
            } else {
                $this->getResponse()->setBody("Unknow Error!");
            }
        }else {
				// There is a problem in the response we got
				$this->cancelAction();
				Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/failure', array('_secure'=>true));
		}
	}
	
	// The cancel action is triggered when an order is to be cancelled
	public function cancelAction() {
        if (Mage::getSingleton('checkout/session')->getLastRealOrderId()) {
            $order = Mage::getModel('sales/order')->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
            if($order->getId()) {
				// Flag the order as 'cancelled' and save it
				$order->cancel()->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, 'Gateway has declined the payment.')->save();
			}
        }
	}
}