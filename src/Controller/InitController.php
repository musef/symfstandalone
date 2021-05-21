<?php
    
namespace App\Controller;

use App\Entity\Productos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\daos\ProductosDaoController;



class InitController extends AbstractController {


    /**
     * @Route("/")
     *
     * @return void
     */
    public function init(ProductosDaoController $daoP) {

        $productos=$daoP->list();

        return $this->render('index.html.twig',[
            'productos'=>$productos,
            'vdisabled'=>'disabled',
            'url_continuar'=>'paso2'
        ]);

    }


    /**
     * @Route("/nav1", name="paso_1")  
     *
     * @param ProductosDaoController $daoP
     * @return void
     */
    public function paso1(ProductosDaoController $daoP) {

        $productos=$daoP->list();

        return $this->render('index.html.twig',[
            'productos'=>$productos,
            'vdisabled'=>'disabled',
            'url_continuar'=>'paso2'
        ]);

    }
}