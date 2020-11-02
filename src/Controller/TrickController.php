<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Paginator;


/**
* @Route("/trick")
*/
class TrickController extends AbstractController
{
    /**
     * $manager construct
     *
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }

    /**
    * @Route("/", name="trick_index", methods={"GET"})
    */
    public function index(TrickRepository $trickRepository): Response
    { 
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findBy([],['creation_date' => 'DESC'])
            ]);
     
    }

   

}