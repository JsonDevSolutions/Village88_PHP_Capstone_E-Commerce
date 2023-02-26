<?php
require_once(APPPATH . '../vendor/autoload.php');

use ClickSend\Api\SMSApi;
use ClickSend\Configuration;
use ClickSend\Model\SmsMessage;

class ClickSend {
    public function sendSMS($to, $message) {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api_key', 'ABC06895-E688-1D6A-E987-AE37593988B0');
        $api_instance = new SMSApi(new GuzzleHttp\Client(), $config);
        $sms_message = new SmsMessage([
            'body' => $message,
            'to' => $to
        ]);
        try {
            $result = $api_instance->smsSendPost($sms_message);
            return true;
        } catch (Exception $e) {
            echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
            return false;
        }
    }
}
