<?php

namespace App\Controller;
use App\Entity\SignUp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\SignUpRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ForgotPasswordType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class LoginController extends AbstractController
{
#[Route('/login', name: 'app_login')]
public function index(Request $request, SignUpRepository $signupRepository): Response
{
    $error = null;
    $user = null;
    if ($request->isMethod('POST')) {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $user = $signupRepository->findOneBy(['email' => $email]);

        if ($user && $user->getPwd() === $password) { 
            if ($user->getType()->getT() === 'Admin') {
                return $this->redirectToRoute('app_signup_list', ['id' => $user->getId()]); 
            } elseif ($user->getType()->getT() === 'Membre') {
                return $this->redirectToRoute('app_sign_up', ['id' => $user->getId()]);
            }
        } else {
            $error = 'E-mail ou mot de passe incorrect.';
        }
    }

    return $this->render('login/index.html.twig', [
        'error' => $error,
        'user' => $user
    ]);
}
  
    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(Request $request, MailerInterface $mailer, SignUpRepository $signUpRepository): Response
    {
        $form = $this->createForm(ForgotPasswordType::class);        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $signUpRepository->findOneBy(['email' => $email]);
            if ($user) {
                $emailMessage  = (new Email())
                    ->from('noreply@example.com') 
                    ->to($user->getEmail()) 
                    ->subject('Récupération de votre mot de passe')
                    ->html('<p>Votre mot de passe est : ' . $user->getPwd() . '</p>');
                $mailer->send($emailMessage );
                return $this->redirectToRoute('app_login');
            } else {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email.');
            }
        }

        return $this->render('login/forgot_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
