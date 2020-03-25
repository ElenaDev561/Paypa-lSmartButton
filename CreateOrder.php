<?php

namespace Sample\CaptureIntentExamples;

require __DIR__ . '../vendor/autoload.php';


use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class CreateOrder
{
    
    /**
     * Setting up the JSON request body for creating the Order. The Intent in the
     * request body should be set as "CAPTURE" for capture intent flow.
     * 
     */
    private static function buildRequestBody()
    {
        return array(
            'intent' => 'CAPTURE',
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'reference_id' => 'PUHF',
                            'description' => 'Sporting Goods',
                            'custom_id' => 'CUST-HighFashions',
                            'soft_descriptor' => 'HighFashions',
                            'amount' =>
                                array(
                                    'currency_code' => 'USD',
                                    'value' => '220.00',
                                   
                                ),
                           
                        ),
                ),
        );
    }

    /**
     * This is the sample function which can be sued to create an order. It uses the
     * JSON body returned by buildRequestBody() to create an new Order.
     */
    public static function createOrder($debug=false)
    {
        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $request->body = self::buildRequestBody();

        $client = PayPalClient::client();
        $response = $client->execute($request);
        if ($debug)
        {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Intent: {$response->result->intent}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            // To toggle printing the whole response body comment/uncomment below line
            echo json_encode($response->result, JSON_PRETTY_PRINT), "\n";
        }


        return $response;
    }
}


/**
 * This is the driver function which invokes the createOrder function to create
 * an sample order.
 */
if (!count(debug_backtrace()))
{
    CreateOrder::createOrder(true);
}



