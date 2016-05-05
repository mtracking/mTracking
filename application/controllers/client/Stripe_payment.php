<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Stripe_payment extends CI_Controller {
 
    public function __construct() {
 
        parent::__construct();
 
        }
 
          public function index()
         {
             $this->load->view('client/payment/stripe');
          }
 
    public function checkout()
    {
        try {   
            require_once(APPPATH.'libraries/Stripe/init.php');//or you
            \Stripe\Stripe::setApiKey("sk_test_ZbdYiQVU3ESbJrl5dy4F4gbr"); //Replace with your Secret Key
 
            $charge = \Stripe\Charge::create(array(
                "amount" => 100000,
                "currency" => "usd",
                "card" => $_POST['stripeToken'],
                "description" => "Demo Transaction"
            ));
            echo "<h1>Your payment has been completed.</h1>";   
        }
 
        catch(Stripe_CardError $e) {
 
        }
        catch (Stripe_InvalidRequestError $e) {
 
        } catch (Stripe_AuthenticationError $e) {
        } catch (Stripe_ApiConnectionError $e) {
        } catch (Stripe_Error $e) {
        } catch (Exception $e) {
        }
    }

    public function test()
    {
        require_once(APPPATH."libraries/2checkout-php/lib/Twocheckout.php");
        Twocheckout::privateKey('EEC5918A-5EC5-4F2D-A7FC-DD5DE0C77730');
        Twocheckout::sellerId('901248204');
        Twocheckout::sandbox(true);
        try {
            $charge = Twocheckout_Charge::auth(array(
                "sellerId" => "901248204",
                "merchantOrderId" => "123",
                "token" => 'MjFiYzIzYjAtYjE4YS00ZmI0LTg4YzYtNDIzMTBlMjc0MDlk',
                "currency" => 'USD',
                "total" => '10.00',
                "billingAddr" => array(
                    "name" => 'Testing Tester',
                    "addrLine1" => '123 Test St',
                    "city" => 'Columbus',
                    "state" => 'OH',
                    "zipCode" => '43123',
                    "country" => 'USA',
                    "email" => 'testingtester@2co.com',
                    "phoneNumber" => '555-555-5555'
                ),
                "shippingAddr" => array(
                    "name" => 'Testing Tester',
                    "addrLine1" => '123 Test St',
                    "city" => 'Columbus',
                    "state" => 'OH',
                    "zipCode" => '43123',
                    "country" => 'USA',
                    "email" => 'testingtester@2co.com',
                    "phoneNumber" => '555-555-5555'
                )
            ));
            var_dump($charge['response']['responseCode']);
        } catch (Twocheckout_Error $e) {
            var_dump($e->getMessage());
            // $this->assertEquals('Bad request - parameter error', $e->getMessage());
        }
    }
 
}