<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Service\Paginator;
use App\Service\FileUploader;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="trick_index", methods={"GET"})
     */
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findBy([], ['creation_date' => 'DESC'])
        ]);
    }

    /**
     * @Route("/{slug}/show/{page<\d+>?1}", name="trick_show", methods={"GET","POST"})
     */
    public function show(Request $request, Trick $trick, Paginator $paginator, $page): Response
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

    /**
     * @Route("/new", name="trick_new", methods={"GET","POST"})
     * @param $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        $trick = new Trick();
        $trick->setUser($this->getUser());
        $trick->getSlug('name');
        $trick->setCreationDate(new \Datetime());

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('message', 'Trick added!');
            /** @var UploadedFile $uploadedFile */
            $images = $form['images']->getData();

            foreach ($images as $image) {
                $uploadedFile = $image->getFile();
                if ($uploadedFile) {
                    $newFilename = $fileUploader->upload($uploadedFile, 'images');
                    $image->setPath($newFilename);
                }
                $image->setTrick($trick);
                $this->manager->persist($image);
            }

            foreach ($trick->getVideos() as $video) {
                $video->setTrick($trick);
                $this->manager->persist($video);
            }
            $this->manager->persist($trick);
            $this->manager->flush();

            return $this->redirectToRoute('trick_index');
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }
}
