<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/front-visiteur', name: 'app_front_visiteur')]
    public function index(): Response
    {
        return $this->render('user/FrontVisiteur.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
