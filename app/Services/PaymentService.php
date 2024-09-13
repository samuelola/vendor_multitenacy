<?php 

namespace App\Services;

class PaymentService{
 
    /**
     * demostrating open and closed principle part 2 code may 
     * break if we make changes in one function
     * so this way violate the best is to create an inteface and a factory class for it
     */
    
    public function payWithCreditCard(){
         // logic for paying with credit card
    }

    public function payWithPaypal(){
        // logic for paying with paypal
    }

    public function payWithWireTransfer(){
        // logic for paying with transfer
    }
}