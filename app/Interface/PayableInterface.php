<?php

namespace App\Interface;

interface PayableInterface
{
    public function paywith();
    
}

class CreditCardPayment implements PayableInterface{
    public function paywith(){
        // execute credit card payment logic
    }
}

class PaypalPayment implements PayableInterface{

    public function paywith(){
         // execute paypal payment logic
    }
}

class WirePayment implements PayableInterface{

    public function paywith(){
        // execute wire payment logic
    }
}
