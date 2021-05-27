<?php

namespace App\Controller\daos\interfaces;

use App\Entity\PedidosClientes;

interface interfacePedidosDao {

    public function show($idPedido);
    
    public function record (PedidosClientes $pedido);

}