<?php 

namespace App\PaymentFactory;

use App\Interface\PayableInterface;
use Exception;

class PaymentFactory{

    public function initializePayment($type){
        if($type === 'credit'){
           return new CreditCardPayment();
        }
        elseif($type === 'paypal'){
           return new PaypalPayment();
        }
        elseif($type === 'wire'){
           return new WirePayment();
        }

        throw new Exception ("Unsupported Payment Method");
    }
}