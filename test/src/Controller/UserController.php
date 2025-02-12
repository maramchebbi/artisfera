<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('user/dashboard.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/membre', name: 'app_membre')]
    public function home(): Response
    {
        return $this->render('user/frontMembre.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    app_musique
    #[Route('/musique', name: 'app_musique')]
    public function musique(): Response
    {
        return $this->render('user/frontMembre.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/login', name: 'app_forgot_password')]
    public function forgotpassword(): Response
    {
        return $this->render('security/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    
}
