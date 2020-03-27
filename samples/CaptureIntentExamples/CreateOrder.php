<?php

namespace Samples\CaptureIntentExamples;

require __DIR__ . '/../../vendor/autoload.php';

use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
class CreateOrder
{   
    
    /**
     * Setting up the JSON request body for creating the Order. The Intent in the
     * request body should be set as "CAPTURE" for capture intent flow.
     * 
     */
    private static function buildRequestBody($amount)
    {

        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => 'https://localhost/success.php',
                    'cancel_url' => 'https://localhost/error.php',
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => 'USD',
                                    'value' => $amount
                                )
                        )
                )
        );
    }

    /**
     * This is the sample function which can be sued to create an order. It uses the
     * JSON body returned by buildRequestBody() to create an new Order.
     */

    public static function createOrder($debug=false,$amount)
    {
        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $request->body = self::buildRequestBody($amount);

        $client = PayPalClient::client();
        $response = $client->execute($request);

        print_r(\json_encode($response->result));
        return json_encode($response->result, JSON_PRETTY_PRINT);
    }
}


/**
 * This is the driver function which invokes the createOrder function to create
 * an sample order.
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
               
                CreateOrder::createOrder(true,(int)$decoded);
                //CreateOrder::createOrder(true,2);
             }
         }
  
    }



