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
use App\Form\CommentType;
use App\Entity\Comment;

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

    /**
    * @Route("/{slug}/show/{page<\d+>?1}", name="trick_show", methods={"GET","POST"})
    */
    public function show(CommentRepository $repo,Request $request, Trick $trick, Paginator $paginator, $page): Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        $paginator
            ->setEntityClass(Comment::class)
            ->setOrder(['creation_date' => 'DESC'])
            ->setPage($page)
            ->setAttribut(['trick' => $trick]);
            return $this->render('trick/show.html.twig', [
                'slug' => $trick->getSlug(),
                'trick' => $trick,
                'paginator' => $paginator,
                'form' => $form->createView(),
                ]);
                    
    }

   

}