<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        return $this->render('home/home.html.twig', [
            
        ]);
    }
}
