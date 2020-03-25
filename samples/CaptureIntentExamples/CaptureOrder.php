<?php

namespace Sample\CaptureIntentExamples;

require __DIR__ . '/../../vendor/autoload.php';
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class CaptureOrder
{

    /**
     * This function can be used to capture an order payment by passing the approved
     * order id as argument.
     * 
     * @param orderId
     * @param debug
     * @returns
     */
    public static function captureOrder($orderId, $debug=false)
    {
        print_r($orderId);
        $request = new OrdersCaptureRequest($orderId);

        $client = PayPalClient::client();
        $response = $client->execute($request);
      
        return json_encode($response->result, JSON_PRETTY_PRINT);
    }
}

/**
 * This is the driver function which invokes the captureOrder function with
 * <b>Approved</b> Order Id to capture the order payment.
 */
if (!count(debug_backtrace()))
{   
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ?
        trim($_SERVER["CONTENT_TYPE"]) : '';

    if ($contentType === "application/json") {

        $content = trim(file_get_contents("php://input"));
        
        $decoded = json_decode($content, true);

      if(!isset($decoded)) {

            print_r("\n");
            print_r("************** orderID error! **************");
            print_r("\n");
            print_r($decoded);
            print_r("\n");

      } else {

            CaptureOrder::captureOrder($decoded, true);
      }
    }
    
    
}