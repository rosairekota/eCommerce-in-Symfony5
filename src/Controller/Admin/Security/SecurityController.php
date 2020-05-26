<?php

namespace App\Controller\Admin\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegistrationUserType;
//classe permettantde gerer les hashage
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
//classe permettantde gerer les erreurs des uesers
use  Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request,EntityManagerInterface $em, UserPasswordEncoderInterface $encoders)
    {
        $user=new User();
        $form_user=$this->createForm(RegistrationUserType::class, $user);
        $form_user->handleRequest($request);
        if ($form_user->isSubmitted() && $form_user->isValid()) {
            // on hashe les pwd
           $hash=$encoders->encodePassword($user,$user->getPassword());
           $user->setPassword($hash);
           $em->persist($user);
           $em->flush();
           return $this->redirectToRoute('security_login');
           
        }
        return $this->render('security/registration.html.twig', [
            'form_user' =>$form_user->createView()
        ]);
    }

     /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $auth){

        $this->addFlash('success',' Connectez-vous maintenant!');
        $lastusername=$auth->getLastUsername();
        return $this->render('security/login.html.twig',[
            'last_username' =>$lastusername,
            'error' =>$auth->getLastAuthenticationError()
        ]);
    }

     /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}
}
