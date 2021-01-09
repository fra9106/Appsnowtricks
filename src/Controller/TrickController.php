<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Entity\TrickLike;
use App\Form\CommentType;
use App\Service\Paginator;
use App\Service\FileUploader;
use App\Security\Voter\TrickVoter;
use App\Repository\TrickRepository;
use App\Repository\CategoryRepository;
use App\Repository\TrickLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
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
            'tricks' => $trickRepository->findAllTricks()
            ]);
    }

    /**
     * @Route("/{slug}", name="trick_category", priority=-1)
     */
    public function category($slug, CategoryRepository $repo): Response
    {
        $category = $repo->findOneBy([
            'slug' => $slug
        ]);

        if(!$category){
            throw $this->createNotFoundException("Cette catégorie n'existe pas !");
        }

        return $this->render('trick/category.html.twig', [
            'slug' => $slug,
            'category' => $category
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
                $this->manager->persist($video);
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
     * @Route("/trick/{slug}/edit", name="trick_edit")
     *
     */
    public function edit(Request $request, Trick $trick, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted(TrickVoter::EDIT, $trick);
        $trick->setUpdateDate(new \Datetime());

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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

            $videos = $form['videos']->getData();
            foreach ($videos as $video) {
                $video->setTrick($trick);
                $this->manager->persist($video);
            }

            $this->manager->persist($trick);
            $this->manager->flush();
            $this->addFlash('message', 'Trick modified!');
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
    public function newComment(Request $request, Trick $trick, EntityManagerInterface $manager, Paginator $paginator, $page): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $comment = new Comment();
        $comment->setUser($this->getUser());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreationDate(new \DateTime())
                ->setTrick($trick);

            $manager->persist($comment);
            $manager->flush();
            $this->addFlash('message', 'Comment added!');
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
        $filesystem = new Filesystem();
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isCsrfTokenValid('delete' . $trick->getId(), $request->request->get('_token'))) {
            foreach ($trick->getImages() as $image) {
                $filesystem->remove('assets/uploads/images/' . $image->getPath());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trick);
            $entityManager->flush();
            $this->addFlash('message', 'trick deleted!');
        }

        return $this->redirectToRoute('trick_index');
    }

    /**
     * add and supp likes
     * 
     * @Route("/{slug}/like", name="trick_like")
     *
     * @param Trick $trick
     * @param EntityManagerInterface $manager
     * @param TrickLikeRepository $trickLikeRepository
     * @return void
     */
    public function like(Trick $trick, EntityManagerInterface $manager, TrickLikeRepository $trickLikeRepository)
    {
        $user = $this->getUser();
        
        if(!$user) return $this->json([
            'code' => 403,
            'Message' => "please get connect !"
        ], 403);

        if($trick->isLikedByUser($user)) {
            $like = $trickLikeRepository->findOneBy([
                'trick' => $trick,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'Message' => "like delete !",
                'likes' => $trickLikeRepository->count(['trick' => $trick])
            ], 200);

        }

        $like = new TrickLike();
        $like->setTrick($trick)
        ->setUser($user);
        
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'Message' => "like added !",
            'likes' => $trickLikeRepository->count(['trick' => $trick])
        ], 200);
    }  
}
