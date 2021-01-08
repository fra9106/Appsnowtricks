<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Form\PasswordUpdateType;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
            return $this->redirectToRoute('app_login');
            
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forgottenPass", name="app_forgotten_password")
     */
    public function forgottenPass(Request $request, UserRepository $userRepository, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator)
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
                    return $this->redirectToRoute('app_login');
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
                return $this->redirectToRoute('app_login');
            }

            //We generate the password reset url 
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            // On génère l'e-mail
            $message = (new TemplatedEmail())
            ->from('noreply@monpersoweb.fr')
            ->to($user->getMail())
            ->htmlTemplate('email/reset_password.html.twig')
            ->context([
                'url' => $url,
                'user' => $user,
                'expiration_date' => new \DateTime('+1 hour')
            ]);
            // we send mail
            $mailer->send($message);

            //addFlash confim mess
            $this->addFlash('message', 'Password reset mail sent !');
            return $this->redirectToRoute('app_login');
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
            return $this->redirectToRoute('app_login');
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

            return $this->redirectToRoute('app_login');
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

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->addFlash('danger', 'You are already logged in !');
             return $this->redirectToRoute('homepage');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }    
}
