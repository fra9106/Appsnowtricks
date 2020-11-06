<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
   /**
    * @Route("/registration", name="security_registration")
    */ 
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('message', 'Vous êtes enregistré!');
            $avatar = $form->get('avatar')->getData();
            if($avatar){
                $fichier = md5(uniqid()) . '.' . $avatar->guessExtension();
                
                $avatar->move(
                    $this->getParameter('img_profile_directory'),
                    $fichier
                );
                $user->setAvatar($fichier);
            }
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
            
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}