<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Productos;
use App\Controller\daos\interfaces\interfaceProductosDao;

/**
 */
class ProductosController extends AbstractController 
{

    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager = $entityManager;

    }

    /**
     * @Route ("/api/products/product/{idProducto}")
     *
     * @param [type] $idProducto
     * @param interfaceProductosDao $cdao
     * @return void
     */
    public function show($idProducto=0, interfaceProductosDao $cdao) {
        
        $result=$cdao->show($idProducto);

        $jsonResponse = $result;

        return $this->json([
            'status'=>'OK',
            'message'=>'Producto obtenido',
            'data'=>$jsonResponse
        ]);        
    }

    /**
     * @Route ("/api/products/list")
     *
     * @return void
     */
    public function list (interfaceProductosDao $cdao) {

        $result=$cdao->list();

        $jsonResponse = $result;

        return $this->json([
            'status'=>'OK',
            'message'=>'Listado de productos obtenido',
            'data'=>$jsonResponse
        ]);
    }
}
