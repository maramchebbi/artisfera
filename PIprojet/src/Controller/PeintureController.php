<?php

namespace App\Controller;

use App\Entity\Peinture;
use App\Entity\Style;
use App\Form\AddEditPeintureType;
use App\Repository\PeintureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PeintureController extends AbstractController
{
    #[Route('/peinture', name: 'app_peinture')]
    public function index(): Response
    {
        return $this->render('peinture/index.html.twig', [
            'controller_name' => 'PeintureController',
        ]);
    }

    #[Route('/peinture/new', name: 'app_peinture_new')]
    public function newPeinture(Request $request,EntityManagerInterface $em){
        $peinture= new Peinture();
        $form= $this->createForm(AddEditPeintureType::class,$peinture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($peinture);
            $em->flush();
            return $this->redirectToRoute('app_peinture_list');
        }
        return $this->render('peinture/form.html.twig',[
            'title' => 'Add peinture',
            'form'=> $form
        ]);
    }

    #[Route('/peinture/edit/{id}', name: 'app_peinture_edit')]
    public function editPeinture($id, Request $request,EntityManagerInterface $em, PeintureRepository $peintureRepository){
        $peinture= $peintureRepository->find($id);
        $form= $this->createForm(AddEditPeintureType::class,$peinture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_peinture_list');
        }
        return $this->render('peinture/form.html.twig',[
            'title' => 'Update Peinture',
            'form'=> $form
        ]);
    }

    #[Route('/peinture/remove/{id}', name: 'app_peinture_remove')]
    public function removePeinture($id, PeintureRepository $peintureRepository, EntityManagerInterface $em){
        $peinture= $peintureRepository->find($id);
        $em->remove($peinture);
        $em->flush();
        return $this->redirectToRoute('app_peinture_list');
        //return new Response('Author deleted');
    }

     #[Route('/peinture/list', name: 'app_peinture_list')]
    public function listPeinture(PeintureRepository $peintureRepository){
        $peinturesDB= $peintureRepository->findAll();
        return $this->render('peinture/list.html.twig',[
            'peintures' => $peinturesDB
        ]);
    } 

    /* #[Route('/list', name: 'app_peinture_list')]
    public function peintureList(ManagerRegistry $doctrine){
        $peintureRepository= $doctrine->getRepository(Peinture::class);
        $peintures= $peintureRepository->findAll();
        return $this->render('peinture/list.html.twig',[
            'peintures' => $peintures
        ]);
    } */
}
