<?php

namespace App\Controller\daos\interfaces;

use App\Entity\Productos;

interface interfaceProductosDao {

    public function show ($idProducto);
    public function list ();

}