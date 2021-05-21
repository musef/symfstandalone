<?php
    
namespace App\Controller;

use App\Entity\Clientes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\daos\ClientesDaoController;

class ClienteController extends AbstractController {




      /**
       * @Route("/nav2", name="paso_2")
       * Pasa pantalla por rastro migas
       * 
       * @return void
       */
      public function miga2() {

            return $this->render('paso2.html.twig',[
                  'id_cliente'=>"0",
                  'url_volver'=>'paso1',
                  'url_continuar'=>'paso3'
            ]);

      }      

      /**
       * @Route("/nav3", name="paso_3")
       * Pasa pantalla por rastro migas
       * 
       * @return void
       */
      public function miga3() {

            return $this->render('paso3.html.twig',[
                  'id_cliente'=>"0",
                  'url_volver'=>'paso2',
                  'url_continuar'=>'paso4'
            ]);

      }

      /**
       * @Route("/nav4", name="paso_4")
       * 
       * @return void
       */
      public function miga4() {

            return $this->render('paso4.html.twig',[
                  'url_volver'=>'paso3',
                  'url_continuar'=>'finalizar'
            ]);

      }




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
     * Al pasar de pantalla, se realiza la grabación automática del cliente
     * 
     * @return void
     */
    public function paso3(Request $request, ClientesDaoController $cdao) {

        $fec=date ('Y-m-d H:i:s',time());
       
        $idC = $request->request->get('id_cliente');

        // grabamos solo si el cliente no existe
        if ($idC == "0") {

            // todos campos son requeridos
            $name = $request->request->get('firstname');
            $apellido1 = $request->request->get('lastname');
            $apellido2 = $request->request->get('lastname2');
            $email = $request->request->get('email');
            $mobile = $request->request->get('mobile');
            $identidad = $request->request->get('identidad');
            $numberdoc = $request->request->get('numberdoc');
            $birthdate = $request->request->get('birthdate');

            if (!is_null($birthdate) && strlen($birthdate) != 10) $birthdate=null;
            
            if (is_null($name) || is_null($apellido1) || is_null($apellido2) || is_null($email) ||
                  is_null($mobile) || is_null($identidad) || is_null($numberdoc) || is_null($birthdate) ) {

                  return $this->render('paso2.html.twig',[
                        'url_volver'=>'paso1',
                        'url_continuar'=>'paso3',
                        'message'=> 'Faltan datos en el formulario'
                  ]);
            }

            $fecNac= \date_create(substr($birthdate,6,4).'-'.substr($birthdate,3,2).'-'.substr($birthdate,0,2));

            $cliente = new Clientes;
            $cliente->setFecha($fec);
            $cliente->setDocIdentidadTipo($identidad);
            $cliente->setDocIdentidad($numberdoc);
            $cliente->setNombre($name);
            $cliente->setApellido1($apellido1);
            $cliente->setApellido2($apellido2);
            $cliente->setFechaNacimiento($fecNac);
            $cliente->setEmail($email);
            $cliente->setTlfMovil($mobile);
    
            $result=$cdao->record($cliente);
    
            if ($result===false) {
                return $this->render('paso2.html.twig',[
                    'url_volver'=>'paso1',
                    'url_continuar'=>'paso3',
                    'message'=> 'Error en la grabación del cliente'
                ]);            
            }
        } else {
            $result=$idC;
        }


        return $this->render('paso3.html.twig',[
            'id_cliente'=>$result,
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