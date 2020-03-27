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
   
        $request = new OrdersCaptureRequest($orderId);

        $client = PayPalClient::client();
        $response = $client->execute($request);

        print_r(\json_encode($response->result));
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Paypal";
        
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sqls = 'DELETE FROM transation WHERE id = 1';

        mysqli_query($conn, $sqls);
        $firstname = $response->result->payer->name->given_name;
        $lastname =  $response->result->payer->name->surname;
        $email_address = $response->result->payer->email_address;
        $currency_code = $response->result->purchase_units[0]->payments->captures[0]->amount->currency_code;
        $amount = $response->result->purchase_units[0]->payments->captures[0]->amount->value;
        $transationID = $response->result->id;

        $sql = "INSERT INTO transation (id, firstname, lastname, email ,amount,currency_code,transationid)
        VALUES (1,'$firstname','$lastname','$email_address','$amount', '$currency_code', '$transationID')";
        
        if (mysqli_query($conn, $sql)) {
            //echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        mysqli_close($conn);
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