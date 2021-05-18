<?php
    
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;



class InitController extends AbstractController {


    /**
     * @Route("/")
     *
     * @return void
     */
    public function init() {

        return $this->render('index.html.twig',[
            'vdisabled'=>'disabled',
            'url_continuar'=>'paso2'
        ]);

    }

    /**
     * @Route("/paso1")     
     *
     * @return void
     */
    public function paso1() {

       return $this->render('index.html.twig',[
        'vdisabled'=>'disabled',
        'url_continuar'=>'paso2'
        ]);

    }

    /**
     * @Route("/recordOrder")
     * TO DO
     *
     * @return void
     */
    public function recordOrder() {

        return new JsonResponse(array(
            'status' => 'OK',
            'message' => 'Puede continuar'),
        200);

    }


}


?>