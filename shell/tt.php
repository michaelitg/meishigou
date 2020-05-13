<?php
set_time_limit(0);
ignore_user_abort(true);
require("../app/Mage.php");  // load the main Mage file

Mage::app();   // not run() because you just want to load Magento, not run it.

$session = Mage::getModel('core/session');

$resource = Mage::getSingleton('core/resource');
$connection = $resource->getConnection('core_read');
$write = $resource->getConnection('core_write');

//echo Mage::getModel('mipay_basicpayment/payment')->getOrderPlaceRedirectUrl();
echo "\nDone\n";

?>