<?php
    
namespace App\Controller;

use App\Entity\Productos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\daos\interfaces\interfaceProductosDao;



class InitController extends AbstractController {


    /**
     * @Route("/")
     *
     * @return void
     */
    public function init(interfaceProductosDao $daoP) {

        $productos=$daoP->list();

        return $this->render('index.html.twig',[
            'id_cliente' => '0',
            'productos'=>$productos,
            'vdisabled'=>'disabled',
            'url_continuar'=>'paso2'
        ]);

    }

    /**
     * @Route("/paso1")
     *
     * @return void
     */
    public function paso1(Request $request, interfaceProductosDao $daoP) {

        $idC = $request->request->get('id_cliente');

        // nuevo formulario si el cliente no existe
        if (is_null($idC)) $idC="0";

        $productos=$daoP->list();

        return $this->render('index.html.twig',[
            'id_cliente' => $idC,
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
    public function miga1(interfaceProductosDao $daoP) {

        $productos=$daoP->list();

        return $this->render('index.html.twig',[
            'id_cliente' => '0',
            'productos'=>$productos,
            'vdisabled'=>'disabled',
            'url_continuar'=>'paso2'
        ]);

    }
}