<?php

namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment which has access
     * credentials context. This can be used invoke PayPal API's provided the
     * credentials have the access to do so.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }
    
    /**
     * Setting up and Returns PayPal SDK environment with PayPal Access credentials.
     * For demo purpose, we are using SandboxEnvironment. In production this will be
     * ProductionEnvironment.
     */
    public static function environment()
    {
        // AR2beAMlmq6FSjI2dZaWPT3b25wXipbKu7f_J1Lc8V_E246S2f-nlFBhK-OIm-TN9GdAt8cVcWu_lLFE
        // ECnAUpJyzGWC1zmnw81xuWVYo4AOW3QcXZkxnUtK9sS5w4Ebmowd06kn8HHjct6i0H1s5hpIhUzIEVot
        
        
        $clientId = getenv("CLIENT_ID") ?: "AZ6yu5HDJMsxjQZEmXAWWbNj2nzmulz4k5t78uplJ8QHm6m8hcXb2viDGrmLL4h-K0f9Aqu4dITkXGIN";
        $clientSecret = getenv("CLIENT_SECRET") ?: "EPF9TqqAR72y5ue2emMNq2QnM8yoKDBok9VFdhSmL7qAjD2JdFKItyFmoUKTJaQ4XrF3IGLreFYXtpFK";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
