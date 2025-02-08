<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeuserController extends AbstractController
{
    #[Route('/typeuser', name: 'app_typeuser')]
    public function index(): Response
    {
        return $this->render('typeuser/index.html.twig', [
            'controller_name' => 'TypeuserController',
        ]);
    }
}
