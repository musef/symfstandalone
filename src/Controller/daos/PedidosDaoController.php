<?php

namespace App\Controller\daos;

use App\Entity\PedidosClientes;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

use Doctrine\ORM\EntityManagerInterface;


/**
 */
class PedidosDaoController extends ServiceEntityRepository
{


    private $em;


    public function __construct(EntityManagerInterface $entityManager) {

        $this->em = $entityManager;

    }




    /**
     * Esta función devuelve el pedido con el id del parámetro recibido
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $pedido = $this->em
            ->getRepository(PedidosClientes::class)
            ->find($id);

        return $pedido;
    }


    
    /**
     */
    public function new(PedidosClientes $pedido)
    {

        $entityManager = $this->em->persist($pedido);
        $entityManager->flush();

        return true;
    }





    /**
     */
    public function edit(PedidosClientes $pedido)
    {

        $id=$pedido->id;

        $product = $this->em->getRepository(Product::class)->find($id);

        $this->em->flush();

        return true;
    }



    /**
     */
    public function delete($id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $pedido = $this->em->getRepository(PedidosClientes::class)->find($id);

        $this->em->remove($pedido);
        $this->em->flush();

        return true;
    }
}
