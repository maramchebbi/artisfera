<?php

namespace App\Controller;

use App\Entity\Peinture;
use App\Entity\Style;
use App\Form\AddEditStyleType;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StyleController extends AbstractController
{
    #[Route('/style', name: 'app_style')]
    public function index(): Response
    {
        return $this->render('style/index.html.twig', [
            'controller_name' => 'StyleController',
        ]);
    }

    
   /*  #[Route('/style/new', name: 'app_style_new')]
    public function newStyle(Request $request,EntityManagerInterface $em){
        $style= new Style();
        $form= $this->createForm(AddEditStyleType::class,$style);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($style);
            $em->flush();
            return $this->redirectToRoute('app_style_list');
        }
        return $this->render('style/form.html.twig',[
            'title' => 'Add style',
            'form'=> $form
        ]);
    }    */

    #[Route('/new', name: 'app_style_new')]
    public function newStyle(Request $request, ManagerRegistry $doctrine){
        $style = new Style();
        //$style->setTitle('Abc'); //champs du formulaire pré-rempli
        $em= $doctrine->getManager();
        $form= $this->createForm(AddEditStyleType::class, $style);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($style);
            $em->flush();
            return $this->redirectToRoute('app_style_list');
        }
        return $this->render('style/form.html.twig', [
            'title' => 'Add Style',
            'form' => $form
        ]);

    }
    #[Route('/style/edit/{id}', name: 'app_style_edit')]
    public function editStyle($id, Request $request,EntityManagerInterface $em, StyleRepository $styleRepository){
        $style= $styleRepository->find($id);
        $form= $this->createForm(AddEditStyleType::class,$style);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_style_list');
        }
        return $this->render('style/form.html.twig',[
            'title' => 'Update Style',
            'form'=> $form
        ]);
    }

    #[Route('/style/remove/{id}', name: 'app_style_remove')]
    public function removeStyle($id, StyleRepository $styleRepository, EntityManagerInterface $em){
        $style= $styleRepository->find($id);
        $em->remove($style);
        $em->flush();
        return $this->redirectToRoute('app_style_list');
        //return new Response('Author deleted');
    }

    #[Route('/style/list', name: 'app_style_list')]
    public function listStyle(StyleRepository $styleRepository){
        $stylesDB= $styleRepository->findAll();
        return $this->render('style/list.html.twig',[
            'styles' => $stylesDB
        ]);
    }
}
