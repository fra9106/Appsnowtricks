<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\AccountType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * 
     * @Route("/profile", name="app_edit_profile")
     *
     */
    public function profile(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);

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
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('message', 'Profile modified !');
        }
        
        return $this->render('user/profile.html.twig',[
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     *@Route("/get-trick-user", name="app_get_trick")
     *
     */
    public function getTrick(TrickRepository $repo): response
    {
        $images = new Image;
        $user = $this->getUser();
        $tricks = $repo->findAll($user);
        return $this->render('trick/trickUser.html.twig', [
            'user' => $user,
            'trick' => $tricks,
            'images' => $images
        ]);
    }
}
