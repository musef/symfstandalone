<?php

namespace App\Controller;

use App\Entity\Productos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

/**
 */
class ProductosController extends AbstractController
{

    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager = $entityManager;

    }


    /**
     *
     * @return void
     */
    public function list()
    {
        $productos = $this->entityManager
                ->getRepository(Productos::class)->findAll();

        return $productos;
    }

    /**
     * @Route("/new", name="productos_dao_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $producto = new Productos();
        $form = $this->createForm(ProductosType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($producto);
            $entityManager->flush();

            return $this->redirectToRoute('productos_dao_index');
        }

        return $this->render('productos_dao/new.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="productos_dao_show", methods={"GET"})
     */
    public function show(Productos $producto): Response
    {
        return $this->render('productos_dao/show.html.twig', [
            'producto' => $producto,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="productos_dao_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Productos $producto): Response
    {
        $form = $this->createForm(ProductosType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productos_dao_index');
        }

        return $this->render('productos_dao/edit.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="productos_dao_delete", methods={"POST"})
     */
    public function delete(Request $request, Productos $producto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('productos_dao_index');
    }
}

