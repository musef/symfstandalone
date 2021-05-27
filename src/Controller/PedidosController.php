<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\interfaces\interfaceOrderClass;

class PedidosController extends AbstractController
{

    /**
     * @Route("/finalizar")
     * 
     * @return void
     */
    public function finalizar(Request $request, interfaceOrderClass $orderClass) {


        // recuperamos los datos
        $idC=$request->request->get('id_cliente');
        $bankpay=$request->request->get('bank');
        $direccion=$request->request->get('verificarDireccion');
        $datos=$request->request->get('datosPersonales');
        $legal=$request->request->get('check_legal');
        $cesionDatos=$request->request->get('check_cesion_datos');

        $cart=$request->request->get('std_carrito');
        $impTotal=$request->request->get('std_importecarrito');
        $impEnvio=$request->request->get('std_enviocarrito');


        // chequeamos la corrección del pedido
        $result=$orderClass->checkOrder($idC, $cart, $bankpay, $legal, $cesionDatos);

        // si está OK, lo grabamos
        if ( $result['status'] == "OK" ) {

            $order = $orderClass->recordOrder($idC, $impTotal, $impEnvio, $cart, $legal, $cesionDatos);

            return $this->render('compra_confirmada.html.twig',[
                'pedido'=>$order
            ]);

        } else {

            return $this->render('paso4.html.twig',[
                'id_cliente'=>$idC,
                'direccion_entrega'=>$direccion,
                'datos_personales'=>$datos,
                'datos_banco'=>$bankpay,
                'pasoFinal'=>true,
                'url_volver'=>'paso3',
                'url_continuar'=>'finalizar',
                'message' => $result['message']
            ]);
        }

    }






}
