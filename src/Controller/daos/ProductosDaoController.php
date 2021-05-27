<?php

namespace App\Controller\daos;

use App\Entity\Productos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

use Doctrine\ORM\EntityManagerInterface;


/**
 */
class ProductosDaoController extends ServiceEntityRepository
{


    private $em;


    public function __construct(EntityManagerInterface $entityManager) {

        $this->em = $entityManager;

    }


    /**
     * Esta función obtiene un listado de todos los productos contenidos
     * en la tabla productos
     *
     * @return void
     */
    public function list()
    {

        $limit=6;

        $qb = $this->em->createQueryBuilder();

        $qb->select('p')
        ->from('App\Entity\Productos', 'p')
        ->where('p.id < :idmax AND p.categoria = :categoria')
        ->orderBy('p.precioPromo', 'ASC')
        ->setMaxResults( $limit ); 
        
        $qb->setParameters(new ArrayCollection([
            new Parameter('idmax', '99'),
            new Parameter('categoria', 'PC')
        ]));
        

        $query = $qb->getQuery();

        $productos = $query->execute();

        return $productos;
    }


    /**
     * Esta función devuelve el producto con el id del parámetro recibido
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $producto = $this->em
            ->getRepository(Productos::class)
            ->find($id);

        return $producto;
    }



}
