<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Clientes;
use App\Entity\PedidosClientes;
use App\Controller\daos\PedidosDaoController;
use App\Controller\daos\ProductosDaoController;
use App\Controller\daos\ClientesDaoController;

class PedidosController extends AbstractController
{

    /**
     * @Route("/finalizar")
     * 
     * @return void
     */
    public function finalizar(Request $request, ClientesDaoController $cdao, ProductosDaoController $pdao, PedidosDaoController $odao) {


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
        $result=$this->checkOrder($idC, $cart, $bankpay, $legal, $cesionDatos, $cdao, $pdao);

        // si está OK, lo grabamos
        if ( $result['status'] == "OK" ) {

            $order = $this->recordOrder($idC, $impTotal, $impEnvio, $cart, $legal, $cesionDatos, $odao);

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



    /**
     * Undocumented function
     *
     * @param [type] $idC
     * @param [type] $cart
     * @param [type] $payment
     * @return void
     */
    private function checkOrder($idC, $cart, $payment, $legal, $cesion, ClientesDaoController $cdao, ProductosDaoController $pdao) {

        $error = false;
        $message = "Pedido correcto";

        $checkErrorCustomer = $this->checkCustomer($idC,$cdao);
        if ($checkErrorCustomer == true) {
            $error = true;
            $message = "Faltan datos de cliente";
        }

        $checkErrorPay = $this->checkPayment($payment);
        if ($checkErrorPay == true) {
            $error = true;
            $message = "Falta pago de pedido";
        } else {
            $this->recordPaymentAndChecks($idC, $payment, $legal, $cesion, $cdao);
        }

        $checkErrorCart = $this->checkCart($cart, $pdao);
        if ($checkErrorCart == true) {

            $message = $cart;
            $message = "Error en los productos del carrito";
        }


        if ($error == false) {
            return array(
                'status'=>'OK',
                'info'=>$idC,
                'message'=>'Pedido Correcto'
            );
        } else  {

            return array(
                'status'=>'Error',
                'info'=>$idC,
                'message'=>$message
            );

        }

    }


    /**
     * Esta función verifica si existe un cliente con el id suministrado,
     * y si el cliente tiene todos los datos necesarios para facturación:
     *
     * @param [type] $idC
     * @param ClientesDaoController $cdao
     * @return void
     */
    private function checkCustomer($idC, ClientesDaoController $cdao) {

        $cliente = $cdao->show($idC);
        if (is_null($cliente)) return true;

        // chequeo datos minimos
        $nom=$cliente->getNombre();
        $ap1=$cliente->getApellido1();
        $ap2=$cliente->getApellido2();
        $dni=$cliente->getDocIdentidad();
        $ema=$cliente->getEmail();
        $tlf=$cliente->getTlfMovil();
        $dir=$cliente->getEnvioDireccion();
        $cps=$cliente->getEnvioCp();
        $loc=$cliente->getEnvioLocalidad();
        $prv=$cliente->getEnvioProvincia();

        if (is_null($nom) || strlen($nom) < 2) return true;
        if (is_null($ap1) || strlen($ap1) < 2) return true;
        if (is_null($ap2) || strlen($ap2) < 2) return true;
        if (is_null($dni) || strlen($dni) < 9) return true;
        if (is_null($ema) || strlen($ema) < 6) return true;
        if (is_null($tlf) || strlen($tlf) != 9 ) return true;
        if (is_null($dir) || strlen($dir) < 5 ) return true;
        if (is_null($cps) || strlen($cps) != 5 ) return true;
        if (is_null($loc) || strlen($loc) < 2 ) return true;
        if (is_null($prv) || strlen($prv) < 4 ) return true;

        return false;

    }


    /**
     * Esta funcion chequea dato de pago es correcto
     *
     * @param [type] $payment
     * @return void
     */
    private function checkPayment($payment) {

        if (is_null($payment) || strlen($payment) != 16 ) return true;

        return false;

    } 
    
    /**
     * Esta funcion chequea que los productos del carrito están OK
     *
     * @param [type] $payment
     * @param ProductosDaoController $pdao
     * @return void
     */
    private function checkCart($cart, ProductosDaoController $pdao) {
    
        $error=false;

        if (is_null($cart) || strlen($cart) < 3 ) return true;

        $carrito = \json_decode($cart);

        foreach ($carrito as $prod) {

            $producto=$pdao->show($prod->id);

            if (is_null($producto)) {
                $error=true;
                break;
            } else {
                if ($prod->price != $producto->getPrecioPromo()) {
                    $error=true;
                    break;
                }
            }
        }
        
        return $error;

    }


    /**
     * Esta funcion graba el pago dentro del cliente despues de 
     * comprobar que el pago es correcto
     *
     * @param [type] $idC
     * @param [type] $payment
     * @param ClientesDaoController $cdao
     * @return void
     */
    private function recordPaymentAndChecks($idC, $payment, $legal, $cesion, ClientesDaoController $cdao) {

        if (is_null($idC) || $idC == "" || $idC=="0" ) return false;

        if (is_null($payment) || strlen($payment) != 16 ) return false;
        if (is_null($legal) || $legal == "") {
            return false;
        } else {
            $legal="true";
        }
        if (is_null($cesion) || $cesion == "") {
            $cesion="false";
        } else {
            $cesion="true";
        }

        return $cdao->updatePaymentAndCheks($idC, $payment, $legal, $cesion);

    } 


    /**
     * Esta función graba el pedido del cliente, con los datos
     * suministrados por parámetro
     *
     * @param [type] $idC
     * @param [type] $impTotal
     * @param [type] $impEnvio
     * @param [type] $cart
     * @param [type] $odao
     * @return void
     */
    private function recordOrder($idC, $impTotal, $impEnvio, $cart, $legal, $cesionDatos, $odao) {

        $fecha = date ('Y-m-d H:i:s',time());
        $tipoIva = 0.21;
        $impTotal = floatval ($impTotal);
        $base = floatval ($impTotal/(1+$tipoIva));
        $iva = floatval ($base*$tipoIva);
        $impEnvio = floatval ($impEnvio);

        $pedido = new PedidosClientes();
        $pedido->setIdCliente($idC);
        $pedido->setFecha($fecha);
        $pedido->setCarrito($cart);
        $pedido->setImporte($base);
        $pedido->setImporteTotal($impTotal);
        $pedido->setIva($iva);
        $pedido->setEnvio($impEnvio);

        $result = $odao->record($pedido);

        return $result;

    }
}
