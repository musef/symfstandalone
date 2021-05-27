<?php

namespace App\Controller\daos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Productos;
use App\Controller\daos\interfaces\interfaceProductosDao;

/**
 */
class ProductosDaoControllerMockup extends ServiceEntityRepository 
{


    private $em;


    public function __construct(EntityManagerInterface $entityManager) {

        $this->em = $entityManager;

    }


    /**
     * Esta función obtiene un listado de todos los productos contenidos
     * en la tabla productos
     *
     * @return void
     */
    public function list()
    {

        $producto = new Productos;
        $producto->setId("1");
        $producto->setNombre("Producto FAKE");
        $producto->setCategoria("PC");
        $producto->setPrecioBase("99.99");
        $producto->setPrecioPromo("88.88");

        $producto2 = new Productos;
        $producto2->setId("2");
        $producto2->setNombre("Producto FAKE DIFERENTE");
        $producto2->setCategoria("PC");
        $producto2->setPrecioBase("55.55");
        $producto2->setPrecioPromo("49.99");

        $productos=array($producto, $producto2);

        return $productos;
    }


    /**
     * Esta función devuelve el producto con el id del parámetro recibido
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $producto = new Productos;
        $producto->setId("1");
        $producto->setNombre("Producto FAKE");
        $producto->setCategoria("PC");
        $producto->setPrecioBase("99.99");
        $producto->setPrecioPromo("88.88");

        return $producto;
    }



}
