<?php
    
namespace App\Controller;

use App\Entity\Clientes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


use App\Controller\daos\interfaces\interfaceClientesDao;

class ClienteController extends AbstractController {



    /**
     * @Route("/paso2")
     * 
     * @return void
     */
    public function paso2(Request $request, interfaceClientesDao $cdao) {

      $idC = $request->request->get('id_cliente');

      // nuevo formulario si el cliente no existe
      if ( is_null($idC) || $idC == "0") {
            $id = '0';
            $name = '';
            $lastname = '';
            $lastname2 = '';
            $email = '';
            $mobile = '';
            $identity = '';
            $numberdoc = '';
            $birthdate = '';

      } else {
            // recuperamos el cliente
            $cliente=$cdao->show($idC);
            if (is_null($cliente)) {
                  $id = '0';
                  $name = '';
                  $lastname = '';
                  $lastname2 = '';
                  $email = '';
                  $mobile = '';
                  $identity = '';
                  $numberdoc = '';
                  $birthdate = '';
            } else {
                  $id = $idC;
                  $name = $cliente->getNombre();
                  $lastname = $cliente->getApellido1();
                  $lastname2 = $cliente->getApellido2();
                  $email = $cliente->getEmail();
                  $mobile = $cliente->getTlfMovil();
                  $identity = $cliente->getDocIdentidadTipo();
                  $numberdoc = $cliente->getDocIdentidad();
                  $birthdate = date_format($cliente->getFechaNacimiento(),"d/m/Y");             
            }


      }

      return $this->render('paso2.html.twig',[
            'id_cliente' => $id,
            'name' => $name,
            'lastname' => $lastname,
            'lastname2' => $lastname2,
            'email' => $email,
            'mobile' => $mobile,
            'identity' => $identity,
            'numberdoc' => $numberdoc,
            'birthdate' => $birthdate,
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
    public function paso3(Request $request, interfaceClientesDao $cdao) {

        $fec=date ('Y-m-d H:i:s',time());
       
        $idC = $request->request->get('id_cliente');

        $calle="";
        $cpostal="";
        $localidad="";
        $provincias=$this->getProvincias();
        $selected="";

        // grabamos solo si el cliente no existe
        if ($idC == "0") {

            // todos campos son requeridos
            $name = $request->request->get('firstname');
            $lastname = $request->request->get('lastname');
            $lastname2 = $request->request->get('lastname2');
            $email = $request->request->get('email');
            $mobile = $request->request->get('mobile');
            $identity = $request->request->get('identidad');
            $numberdoc = $request->request->get('numberdoc');
            $birthdate = $request->request->get('birthdate');

            if (!is_null($birthdate) && strlen($birthdate) != 10) $birthdate=null;
            
            if (is_null($name) || is_null($lastname) || is_null($lastname2) || is_null($email) ||
                  is_null($mobile) || is_null($identity) || is_null($numberdoc) || is_null($birthdate) ) {

                  return $this->render('paso2.html.twig',[
                        'id_cliente' => $idC,
                        'name' => $name,
                        'lastname' => $lastname,
                        'lastname2' => $lastname2,
                        'email' => $email,
                        'mobile' => $mobile,
                        'identity' => $identity,
                        'numberdoc' => $numberdoc,
                        'birthdate' => $birthdate,                        
                        'url_volver'=>'paso1',
                        'url_continuar'=>'paso3',
                        'message'=> 'Faltan datos en el formulario'
                  ]);
            }

            $fecNac= \date_create(substr($birthdate,6,4).'-'.substr($birthdate,3,2).'-'.substr($birthdate,0,2));

            $cliente = new Clientes;
            $cliente->setFecha($fec);
            $cliente->setDocIdentidadTipo($identity);
            $cliente->setDocIdentidad($numberdoc);
            $cliente->setNombre($name);
            $cliente->setApellido1($lastname);
            $cliente->setApellido2($lastname2);
            $cliente->setFechaNacimiento($fecNac);
            $cliente->setEmail($email);
            $cliente->setTlfMovil($mobile);
    
            $result=$cdao->record($cliente);
    
            if ($result===false) {
                return $this->render('paso2.html.twig',[
                    'id_cliente' => '0',
                    'name' => $name,
                    'lastname' => $lastname,
                    'lastname2' => $lastname2,
                    'email' => $email,
                    'mobile' => $mobile,
                    'identity' => $identity,
                    'numberdoc' => $numberdoc,
                    'birthdate' => $birthdate,                     
                    'url_volver'=>'paso1',
                    'url_continuar'=>'paso3',
                    'message'=> 'Error en la grabación del cliente'
                ]);            
            }
        } else {
            $cliente=$cdao->show($idC);
            if (is_null($cliente)) {
                  // cliente fallido o inexistente
                  $name = '';
                  $lastname = '';
                  $lastname2 = '';
                  $email = '';
                  $mobile = '';
                  $identity = '';
                  $numberdoc = '';
                  $birthdate = '';
                  return $this->render('paso2.html.twig',[
                        'id_cliente' => '0',
                        'name' => $name,
                        'lastname' => $lastname,
                        'lastname2' => $lastname2,
                        'email' => $email,
                        'mobile' => $mobile,
                        'identity' => $identity,
                        'numberdoc' => $numberdoc,
                        'birthdate' => $birthdate, 
                        'url_volver' => 'paso1',
                        'url_continuar' => 'paso3',
                        'message' => 'Cliente inexistente'
                  ]);                  
            } else {
                  // recuperamos el cliente
                  $calle=$cliente->getEnvioDireccion();
                  $cpostal=$cliente->getEnvioCp();
                  $localidad=$cliente->getEnvioLocalidad();
                  $selected=$cliente->getEnvioProvincia(); 
            }

            $result=$idC;
        }

        return $this->render('paso3.html.twig',[
            'id_cliente'=>$result,
            'calle' => $calle,
            'cpostal' => $cpostal,
            'localidad' => $localidad,
            'provincias' => $provincias,
            'selected' => $selected,         
            'url_volver'=>'paso2',
            'url_continuar'=>'paso4'
        ]);

    }

    /**
     * @Route("/paso4")
     * Esta funcion complementa los datos del cliente, grabando los
     * datos de envío
     * 
     * @return void
     */
    public function paso4(Request $request, interfaceClientesDao $cdao) {



      $direccionEntrega="";
      $datosPersonales="";
      $bankpay="";
      $provincias=$this->getProvincias();
      $selected="";
      
      $idC = $request->request->get('id_cliente');

      // todos campos son requeridos
      $calle = trim($request->request->get('calle'));
      $cpostal = trim($request->request->get('codigo_postal'));
      $localidad = trim($request->request->get('localidad'));
      $provincia = trim($request->request->get('provincia'));

      // grabamos solo si hay cliente
      if ($idC != "0") {

          if ( is_null($calle) || is_null($cpostal) || is_null($localidad) || is_null($provincia) 
              || strlen($calle) < 4 || strlen($cpostal) != 5 || strlen($localidad) < 2 || strlen ($provincia) < 4) {

                  return $this->render('paso3.html.twig',[
                      'id_cliente' => $idC,
                      'calle' => $calle,
                      'cpostal' => $cpostal,
                      'localidad' => $localidad,
                      'provincia' => $provincia, 
                      'provincias' => $provincias,    
                      'selected' => $selected,                 
                      'url_volver'=>'paso2',
                      'url_continuar'=>'paso4',
                      'message'=> 'Faltan datos en el formulario'
                  ]);
          }

          // obtenemos el cliente
          $cliente=new Clientes;
          $cliente=$cdao->show($idC);

          $cliente->setEnvioCp($cpostal);
          $cliente->setEnvioLocalidad($localidad);
          $cliente->setEnvioProvincia($provincia);
          $cliente->setEnvioDireccion($calle);

          $result=$cdao->update($cliente);

          if ($result===false) {
              return $this->render('paso3.html.twig',[
                  'id_cliente' => $idC,
                  'calle' => $calle,
                  'cpostal' => $cpostal,
                  'localidad' => $localidad,
                  'provincia' => $provincia,  
                  'provincias' => $provincias,    
                  'selected' => $selected,                     
                  'url_volver'=>'paso2',
                  'url_continuar'=>'paso4',
                  'message'=> 'Error en la grabación del pedido'
              ]);            
          }

          $datosPersonales=$cliente->getNombre().' '.$cliente->getApellido1().' '.$cliente->getApellido2().' - Movil: '.$cliente->getTlfMovil().' - Email: '.$cliente->getEmail();
          $direccionEntrega=$calle.' '.$cpostal.' '.$localidad;

      } else {
              return $this->render('paso3.html.twig',[
                  'id_cliente' => 0,
                  'calle' => $calle,
                  'cpostal' => $cpostal,
                  'localidad' => $localidad,
                  'provincia' => $provincia, 
                  'provincias' => $provincias,    
                  'selected' => $selected,                                         
                  'url_volver'=>'paso1',
                  'url_continuar'=>'paso3',
                  'message'=> 'Pedido sin cliente, rellene el paso 2'
              ]);
      }


      return $this->render('paso4.html.twig',[
              'id_cliente'=>$idC,
              'direccion_entrega'=>$direccionEntrega,
              'datos_personales'=>$datosPersonales,
              'datos_banco'=>$bankpay,
              'pasoFinal'=>true,
              'url_volver'=>'paso3',
              'url_continuar'=>'finalizar'
          ]);

    }


    public function getProvincias() {
            $arrayProv=array("Alava","Albacete","Alicante","Almeria",
                  "Asturias","Avila","Badajoz","Barcelona","Burgos","Caceres",
                  "Cadiz","Cantabria","Castellon","Ceuta","Ciudad Real","Cordoba","A Coruña",
                  "Cuenca","Girona","Granada","Guadalajara","Guipuzcoa","Huelva","Huesca",
                  "Baleares","Jaen","Leon","Lleida","Lugo","Madrid","Malaga","Melilla",
                  "Murcia","Navarra","Ourense","Palencia","Las Palmas","Pontevedra","La Rioja",
                  "Salamanca","Santa Cruz De Tenerife","Segovia","Sevilla","Soria",
                  "Tarragona","Teruel","Toledo","Valencia","Valladolid",
                  "Vizcaya","Zamora","Zaragoza");
      
      return $arrayProv;
    }
}


?>