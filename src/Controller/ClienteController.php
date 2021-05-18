<?php
    
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;



class ClienteController extends AbstractController {



    /**
     * @Route("/paso2")
     * 
     * @return void
     */
    public function paso2() {

        return $this->render('paso2.html.twig',[
                'url_volver'=>'paso1',
                'url_continuar'=>'paso3'
            ]);

    }

    /**
     * @Route("/paso3")
     * 
     * @return void
     */
    public function paso3() {

        return $this->render('paso3.html.twig',[
            'url_volver'=>'paso2',
            'url_continuar'=>'paso4'
        ]);

    }

    /**
     * @Route("/paso4")
     * 
     * @return void
     */
    public function paso4() {

        return $this->render('paso4.html.twig',[
            'url_volver'=>'paso3',
            'url_continuar'=>'finalizar'
        ]);

    }

    /**
     * @Route("/finalizar")
     * 
     * @return void
     */
    public function finalizar() {

        return $this->render('compra_confirmada.html.twig',[
            'pedido'=>'XXX9999'
        ]);

    }

}


?>