<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home(TrickRepository $repo): Response
    {
        $images = new Image;
        $tricks = $repo->findBy([],['creation_date' => 'DESC']);
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $tricks,
            'images' => $images
        ]);
        
    }
}
