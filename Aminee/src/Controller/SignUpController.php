<?php

namespace  App\Controller;

use App\Entity\SignUp;
use App\Form\AddSignUpType;
use App\Form\AddUserType;
use App\Form\EditSignupType;
use App\Form\EditUserType;
use App\Repository\SignUpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ForgotPasswordType;
use Symfony\Component\Security\Core\Security;


class SignUpController extends AbstractController
{
    #[Route('/sign/up/{id}', name: 'app_sign_up')]
    public function index($id, SignUpRepository $signupRepository): Response
    {
        $user = $signupRepository->find($id);
        return $this->render('sign_up/index.html.twig', [
            'user' => $user
        ]);
    }
    #[Route('/signup/list/{id}', name: 'app_signup_list')]
    public function listsignup($id,SignUpRepository $signupRepository){
        $signupsDB= $signupRepository->findAll();
        $user = $signupRepository->find($id);
        return $this->render('sign_up/list.html.twig',[
            'signups' => $signupsDB,
            'user' => $user

        ]);
    }   
    //hedhi teb3a lajout mta3 l admin 
    #[Route('/signup/new', name: 'app_signup_new')]
    public function newsignup(Request $request,EntityManagerInterface $em){
        $signup= new SignUp();
        $form= $this->createForm(AddUserType::class,$signup);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            try {
                $em->persist($signup);
                $em->flush();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                return new Response("L'email est déjà utilisé. Choisissez un autre email.");
            }
            return $this->redirectToRoute('app_login');
        }
        return $this->render('sign_up/formadd.html.twig',[
            'title' => 'Add signup',
            'form'=> $form
        ]);
    }   
    //hedhi teb3a lajout mta3 l membre li ma ynajemch yzid admin
    #[Route('/signup/membre', name: 'app_signup_newMembre')]
    public function newsignupmembre(Request $request,EntityManagerInterface $em){
        $signup= new SignUp();
        $form= $this->createForm(AddSignUpType::class,$signup);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            try {
                $em->persist($signup);
                $em->flush();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                return new Response("L'email est déjà utilisé. Choisissez un autre email.");
            }
            return $this->redirectToRoute('app_login');
        }
        return $this->render('sign_up/formaddmembre.html.twig',[
            'title' => 'Add signup',
            'form'=> $form
        ]);
    }
    //w hedha l edit ta3 l admin
    #[Route('/signup/edit/{id}', name: 'app_signup_edit')]
    public function editsignup($id, Request $request,EntityManagerInterface $em, SignUpRepository $signupRepository){
        $signup= $signupRepository->find($id);
        $form= $this->createForm(EditUserType::class,$signup);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('app_signup_list', ['id' => $signup->getId()]);
        }
        return $this->render('sign_up/formedit.html.twig',[
            'title' => 'Update signup',
            'form'=> $form //​ return $this->render('formation/template_name.html.twig', [ 'formA' => $form->createView()]);
        ]);
    }
     //hedha edit ta3 l membre 
    #[Route('/signup/editProfil/{id}', name: 'app_signup_editProfile')]
    public function editProfilsignup($id, Request $request, EntityManagerInterface $em, SignUpRepository $signupRepository): Response
    {
        $signup = $signupRepository->find($id);
         $form = $this->createForm(EditSignUpType::class, $signup);
        $form->handleRequest($request);
        $ancienType = $signup->getType()->getT();


    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            if ($signup->getType()->getT() !== $ancienType) {    
                return $this->redirectToRoute('app_login');
            }
                return $this->redirectToRoute('app_sign_up', ['id' => $signup->getId()]);
        }
    
        return $this->render('sign_up/formeditMembre.html.twig', [
            'title' => 'Update signup',
            'form' => $form,
        ]);
    }
    

// behi hedhi ken remouvite bech tsir deconnection automatique 
    #[Route('/signup/remove/{id}', name: 'app_signup_remove')] //#[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'categorie', cascade:["remove"])]
    public function removesignup($id, SignupRepository $signupRepository, EntityManagerInterface $em){
        $signup= $signupRepository->find($id);
        $em->remove($signup);
        $em->flush();
        return $this->redirectToRoute('app_login');
       
    }    
    // behi hedhi ken remouvite w temchi lil liste 

    #[Route('/signup/removee/{id}', name: 'app_signup_remove_admine')] //#[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'categorie', cascade:["remove"])]
public function deleteUser($id, SignUpRepository $signupRepository, Request $request,EntityManagerInterface $entityManager): Response
{    $signup = $signupRepository->find($id);
    if (!$signup) {
        throw $this->createNotFoundException('Utilisateur non trouvé');
    }
    $entityManager->remove($signup);
    $entityManager->flush();
    if ($id == $request->get('id')) {
        return $this->redirectToRoute('app_login');
    } else {
        return $this->redirectToRoute('app_signup_list', ['id' => $request->get('id')]);
    }
}
}