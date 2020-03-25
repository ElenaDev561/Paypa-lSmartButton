<?php

namespace Test;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class TestHarness
{
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }
    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "AR2beAMlmq6FSjI2dZaWPT3b25wXipbKu7f_J1Lc8V_E246S2f-nlFBhK-OIm-TN9GdAt8cVcWu_lLFE";
        $clientSecret = getenv("CLIENT_SECRET") ?: "ECnAUpJyzGWC1zmnw81xuWVYo4AOW3QcXZkxnUtK9sS5w4Ebmowd06kn8HHjct6i0H1s5hpIhUzIEVot";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
