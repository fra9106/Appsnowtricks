<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Form\PasswordUpdateType;
use App\Repository\UserRepository;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
   /**
    * @Route("/registration", name="security_registration")
    */ 
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response 
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
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
            $this->addFlash('message', 'Vous êtes enregistré!');
            return $this->redirectToRoute('security_login');
            
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout",methods="POST")
     */
    public function logout(){}

    /**
     * @Route("/forgottenPass", name="app_forgotten_password")
     */
    public function forgottenPass(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        //create form
        $form = $this->createForm(ResetPasswordType::class);
        //processing form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //We recover the data
            $data = $form->getData();

            //We are looking for a user with this mail
            $user = $userRepository->findOneByMail($data['mail']);
                //If the user does not exist 
                if ($user === null) {
                    //add Flash message
                    $this->addFlash('danger', 'unknown email address');
                    //return at login page
                    return $this->redirectToRoute('security_login');
                    }
            //We generate a token
            $token = $tokenGenerator->generateToken();

            //We try to write the token in the database 
            try{
                $user->setResetToken($token);
                $em= $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', 'An error has occurred : '. $e->getMessage());
                return $this->redirectToRoute('security_login');
            }

            //We generate the password reset url 
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            // On génère l'e-mail
            $message = (new \Swift_Message('Mot de passe oublié'))
            ->setFrom('contact@monpersoweb.fr')
            ->setTo($user->getMail())
            ->setBody(
            "<p>Bonjour,</p>Pour votre demande de réinitialisation de mot de passe pour le site Mon persoweb.fr. Veuillez cliquer sur le lien suivant : " . $url,
            'text/html'
            );
            // we send mail
            $mailer->send($message);

            //addFlash confim mess
            $this->addFlash('message', 'Password reset mail sent !');
            return $this->redirectToRoute('security_login');
        }

        //We send the form to the view 
        return $this->render('security/forgotten.html.twig',['emailForm' => $form->createView()]);
    }

    /**
     * @Route("/resetPassword/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
    //check user with his token
    $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        //if user not exist
        if ($user === null) {
            //add flash mess
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('security_login');
        }

        //if form send post
        if ($request->isMethod('POST')) {
            //delete token
            $user->setResetToken(null);

            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //add flash mess
            $this->addFlash('message', 'Password updated');

            return $this->redirectToRoute('security_login');
        }else {
            return $this->render('security/resetPassword.html.twig', ['token' => $token]);
        }

    }

    /**
     * @Route("/update-password", name="app_update_password")
     *
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder,EntityManagerInterface $manager): Response
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                $form->get('oldPassword')->addError(new FormError("Mot de passe erroné !"));
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);
                $user->setPassword($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('message', 'Password modified !');
            }
        }
        return $this->render('security/passwordUpdate.html.twig', [
            'form' => $form->createView()
        ]);

    }    
}
