<?php
/*
 *      Created By : HB
 *      Created On : 28-03-2011
 *      Issue #    : 2978
 */
class soap_login
{
    var $session_id;
    var $error = "no";
    function login()
    {
            global $soapClient;
            $soapClient = new SoapClient(NULL,
                array(
                    //"location" => 'http://www.greffe-cheveux.fr/sugarcrm/service/v3/soap.php',
                    "location" => 'https://medcom.sugaropencloud.eu/soap.php',
                    "uri" => 'http://www.sugarcrm.com/sugarcrm',
                    )
                );

			// Login
            $user_name = 'admin';
            $user_password = '71734fd4817ea83d41f4d3b52df60fd4';

            try {
                $info = $soapClient->login(
                    array(
                        'user_name' => $user_name,
                        'password'  => $user_password,
                        )
                    );
            }
            catch (SoapFault $fault) {
                $this->error = "yes";
                die("Sorry, the service returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring.".");
            }

            $this->session_id = $info->id;
    }
}
?>
