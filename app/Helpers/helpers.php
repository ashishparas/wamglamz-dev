<?php 

namespace App\Helpers;
use Stripe;
class Helper
{
 
   
   public static function CreateCustomer($data){
      
            $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
            
            $customer = $stripe->customers->create($data);
            
            
            
       
   }
   

   
   
}