<?php

namespace App\Controller\interfaces;




interface interfaceOrderClass {

    public function recordOrder($idC, $impTotal, $impEnvio, $cart, $legal, $cesionDatos);

    public function checkOrder($idC, $cart, $payment, $legal, $cesion);

}