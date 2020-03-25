<?php

namespace Sample\CaptureIntentExamples;

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
                    'return_url' => 'https://ghanabadminton.org/return',
                    'cancel_url' => 'https://ghanabadminton.org/cancel',
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
    // $am = array();
    // if(isset($_POST['amount']) && isset($_POST['request']))
    // {
    //     $am = $_POST['amount'];       
        
    //     return "success";
    // }
    // else {
        
    //     print_r("faled");        
    //     $am = 0;
    //     return "failed ";
    // }
    
    // print_r($am);
    // if($am[0]!=0 && $am[1]==0)
    //     CreateOrder::createOrder(true,$am[0]);
    // else if($am[0]==0 && $am[1] !=0 )
    //     CreateOrder::createOrder(true,$am[1]);
    CreateOrder::createOrder(true,10);
}



