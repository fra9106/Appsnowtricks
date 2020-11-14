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
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Security\Voter\TrickVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $trick = new Trick();
        $trick->setUser($this->getUser());
        $trick->getSlug('name');
        $trick->setCreationDate(new \Datetime());

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
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
                $this->manager->persist($video);dd($video);
            }
            $this->manager->persist($trick);
            $this->manager->flush();
            $this->addFlash('message', 'Trick added!');
            return $this->redirectToRoute('trick_index');
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/trick/{slug}/edit", name="trick_edit", methods={"GET","POST"})
    * @param $fileUploader
    */
    public function edit(Request $request, Trick $trick, FileUploader $fileUploader): Response
    {
                
        $this->denyAccessUnlessGranted(TrickVoter::EDIT, $trick);
        $trick->setUpdateDate(new \Datetime());
        $originImages = new ArrayCollection();
        $originVideos = new ArrayCollection();    
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
                    
            if ($form->isSubmitted() && $form->isValid()) {
                foreach($originImages as $image) {
                    if (false === $trick->getImages()->contains($image)) {
                        $image->getTrick()->removeElement($trick);
                        $this->manager->persist($image);
                    }
                }
                
                $images = $form['images']->getData();
                //dd($images);
                foreach ($images as $image) {
                $uploadedFile = $image->getFile();
                    if ($uploadedFile) {
                        $newFilename = $fileUploader->upload($uploadedFile, 'images');
                        $image->setPath($newFilename);
                    }
                $image->setTrick($trick);
                $this->manager->persist($image);
                }   
                foreach ($originVideos as $video) {
                    if (false === $trick->getVideos()->contains($video)) {
                        $video->getTrick()->removeElement($trick);
                        $this->manager->persist($video);
                    }
                }
 
                $videos = $form['videos']->getData();
                foreach($videos as $video) {
                    $video->setTrick($trick);
                     $this->manager->persist($video);
                }
                $this->manager->persist($trick);
                $this->manager->flush();
                
                return $this->redirectToRoute('trick_show', [
                'slug' => $trick->getSlug()
                ]); 
            }
                return $this->render('trick/edit.html.twig', [
                    'trick' => $trick,
                    'form' => $form->createView(),
                    ]);
    }

    /**
    * @Route("/{slug}/newcomment/{page<\d+>?1}", name="comment_new", methods={"GET","POST"})
    */
    public function newComment(Request $request, Trick $trick, EntityManagerInterface $manager,Paginator $paginator, $page) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $comment = new Comment();
        $comment->setUser($this->getUser());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash('message', 'Comment added!');
                $comment->setCreationDate(new \DateTime())
                        ->setTrick($trick);
                $manager->persist($comment);
                $manager->flush();
                        
                return $this->redirectToRoute('trick_show', [
                        'id' => $trick->getId(),
                        'slug' => $trick->getSlug(),
                        ]);
                }
            $paginator
            ->setEntityClass(Comment::class)
            ->setOrder(['creation_date' => 'DESC'])
            ->setPage($page)
            ->setAttribut(['trick' => $trick]);
                           
                            
                    
            return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'slug' => $trick->getSlug(),
            'paginator' => $paginator,
            'form' => $form->createView(),
            ]);
        }
    /**
    * @Route("/{id}/delete", name="trick_delete", methods={"DELETE"})
    */
    public function delete(Request $request, Trick $trick): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
            if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($trick);
                $entityManager->flush();
            }
                    
        return $this->redirectToRoute('trick_index');
    }

    /**
     * @Route("/{id}/delete-comment", name="comment_delete", methods={"DELETE"})
     * @ParamConverter("comment", options={"id" = "id"})
     * @return Response
     */
    public function deleteComment(Request $request, Comment $comment, Trick $trick, Paginator $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'slug' => $trick->getSlug(),
            'paginator' => $paginator,
            'comment' => $comment
        
            ]);
    }
}
