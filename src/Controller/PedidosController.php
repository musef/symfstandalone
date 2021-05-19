<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\
use Symfony\Component\Routing\Annotation\Route;

class PedidosController extends AbstractController
{
    /**
     * @Route("/recordOrder", name="recordOrder")
     */
    public function index()
    {
        return $this->json([
            'status' => 'OK',
            'message' => 'Todo bien']
        );
    }
}
