<?php
class Mipay_BasicPayment_Helper_Data extends Mage_Core_Helper_Data{
    public function makeRandomString($bits = 256) {
        $bytes = ceil($bits / 8);
        $return = '';
        for ($i = 0; $i < $bytes; $i++) { $return .= chr(mt_rand(0, 255)); }
        return $return;
    }

	public  function getApiKey()
    {
        $m_number = "0012942423";
        $timestamp = time();
        $nonce_str = hash('sha512', $this->makeRandomString());
        $secretKey = "f539fe1b0e7c48429d448cc76dd3d9d3";
        $originString = "0012942423&$timestamp&$non_str&$secretKey";
        $sign = strtoupper(md5($originString));
        return "m_number=$m_number&timestamp=$timestamp&nonce_str=$nonce_str&sign=$sign";
    }
}