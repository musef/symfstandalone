<?php

namespace App\Controller\daos\interfaces;

use App\Entity\Clientes;

interface interfaceClientesDao {

    public function show($idCliente);
    public function record (Clientes $cliente);
    public function update (Clientes $cliente);
    public function updatePaymentAndCheks($idCliente, $payment, $legal, $cesion);

}