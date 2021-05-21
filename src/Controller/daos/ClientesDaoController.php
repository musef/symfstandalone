<?php

namespace App\Controller\daos;

use App\Entity\Clientes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

use Doctrine\ORM\EntityManagerInterface;


/**
 */
class ClientesDaoController extends ServiceEntityRepository
{

    private $em;


    public function __construct(EntityManagerInterface $entityManager) {

        $this->em = $entityManager;

    }



    /**
     * Esta función devuelve el Cliente con el id del parámetro recibido
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $cliente = $this->em
            ->getRepository(Clientes::class)
            ->find($id);

        return $cliente;
    }


    /**
     * Esta fun
     *
     * @param [type] $Cliente
     * @return void
     */
    public function new(Clientes $Cliente)
    {

        $this->em->persist($Cliente);
        $this->em->flush();

        return true;
    }

    public function record($cliente)

    {
        // $em instanceof EntityManager
        $this->em->beginTransaction(); // suspend auto-commit
        try {
            $this->em->persist($cliente);
            $this->em->flush();

            $this->em->getConnection()->commit();

            return $cliente->getId();

        } catch (Exception $e) {

            $this->em->getConnection()->rollBack();

            return false;
        }
    }


    /**
     */
    public function edit(Clientes $Cliente)
    {

        $id=$Cliente->id;

        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);


        $entityManager->flush();

        return true;
    }


}
