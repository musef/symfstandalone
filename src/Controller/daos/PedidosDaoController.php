<?php

namespace App\Controller\daos;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\PedidosClientes;
use App\Controller\daos\interfaces\interfacePedidosDao;

/**
 */
class PedidosDaoController extends ServiceEntityRepository implements interfacePedidosDao
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


    
    public function record(PedidosClientes $pedido)

    {
        // $em instanceof EntityManager
        $this->em->beginTransaction(); // suspend auto-commit
        try {
            $this->em->persist($pedido);
            $this->em->flush();

            $this->em->getConnection()->commit();

            return $pedido->getId();

        } catch (Exception $e) {

            $this->em->getConnection()->rollBack();

            return false;
        }
    }    
}
