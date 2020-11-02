<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Video;


class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User;
        $password = $this->encoder->encodePassword($user, 'toto');
        $user->setPseudo('toto')
             ->setMail('toto@toto.com')
             ->setPassword($password)
             ->setAvatar('');

             $manager->persist($user);

        $user1 = new User;
        $password = $this->encoder->encodePassword($user, 'tata');
        $user1->setPseudo('tata')
             ->setMail('tata@tata.com')
             ->setPassword($password)
             ->setAvatar('');

             $manager->persist($user1);

             $user2 = new User;
             $password = $this->encoder->encodePassword($user, 'tutu');
             $user2->setPseudo('tutu')
                  ->setMail('tutu@tutu.com')
                  ->setPassword($password)
                  ->setAvatar('');
     
                  $manager->persist($user1);

        $category1 = new Category();
        $category1->setCategory("Regular");
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setCategory("Rotations");
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setCategory("Straight Airs");
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setCategory("Old School");
        $manager->persist($category4);

        $category4 = new Category();
        $category4->setCategory("For absolute beginner");
        $manager->persist($category4);

        $video1 = new Video();
        $video1
            ->setName("5 Skills for Beginner Snowboard Tricks")
            ->setUrl("https://www.youtube.com/embed/8AWdZKMTG3U")
        ;
        $manager->persist($video1);

        $video2 = new Video();
        $video2
            ->setName("10 Snowboard Butter Tricks to Learn First")
            ->setUrl("https://www.youtube.com/embed/G9qlTInKbNE")
        ;
        $manager->persist($video2);

        $video3 = new Video();
        $video3
            ->setName("4 Snowboarding Moves That Will Change Your Life")
            ->setUrl("https://www.youtube.com/embed/CflYbNXZU3Q")
        ;
        $manager->persist($video3);

        $video4 = new Video();
        $video4
            ->setName("Extreme Snowboarding")
            ->setUrl("https://www.youtube.com/embed/NKHYEOAbFyM")
        ;
        $manager->persist($video4);

        $video5 = new Video();
        $video5
            ->setName("How To Nose & Tail Press On A Snowboard (Regular)")
            ->setUrl("https://www.youtube.com/embed/P72Q5XGMyDo")
        ;
        $manager->persist($video5);

        $video6 = new Video();
        $video6
            ->setName("Learn How To Snowboard: Straight Air")
            ->setUrl("https://www.youtube.com/embed/9-FUTXxvvpQ")
        ;
        $manager->persist($video6);

        $video7 = new Video();
        $video7
            ->setName("How To Counter Rotated 360 On A Snowboard")
            ->setUrl("https://www.youtube.com/embed/RgS3fpYmd6U")
        ;
        $manager->persist($video7);

        $video8 = new Video();
        $video8
            ->setName("Ski Tricks || Straight Airs")
            ->setUrl("https://www.youtube.com/embed/V_7lXq5gRho")
        ;
        $manager->persist($video8);

        $video9 = new Video();
        $video9
            ->setName("10 WEIRD SNOWBOARD TRICKS (Old School)")
            ->setUrl("https://www.youtube.com/embed/Zc8Gu8FwZkQ")
        ;
        $manager->persist($video9);

        $video10 = new Video();
        $video10
            ->setName("Snowboard Trick Tips: Basic Airs")
            ->setUrl("https://www.youtube.com/embed/RgS3fpYmd6U")
        ;
        $manager->persist($video10);

        $image1 = new Image;
        $image1
            ->setFile('backside-180.jpg');
            $manager->persist($image1);

        $image2 = new Image;
        $image2
            ->setFile('12.jpg');
            $manager->persist($image2);

        $image3 = new Image;
        $image3
            ->setFile('backside-air.png');
            $manager->persist($image3);

        $image4 = new Image;
        $image4
            ->setFile('flip.jpg');
            $manager->persist($image4);

        $image5 = new Image;
        $image5
            ->setFile('frontside-360.jpg');
            $manager->persist($image5);

        $image6 = new Image;
        $image6
            ->setFile('method.jpg');
            $manager->persist($image6);

        $image7 = new Image;
        $image7
            ->setFile('Mjc3MDk1MQ.jpeg');
            $manager->persist($image7);

        $image8 = new Image;
        $image8
            ->setFile('saut.jpg');
            $manager->persist($image8);

        $image9 = new Image;
        $image9
            ->setFile('mute.jpg');
            $manager->persist($image9);

        $image10 = new Image;
        $image10
            ->setFile('mctwist.jpg');
            $manager->persist($image10);

        $image11 = new Image;
        $image11
            ->setFile('Picswiss_VD-44-23.jpg');
            $manager->persist($image11);

        $image12 = new Image;
        $image12
            ->setFile('tail.jpg');
            $manager->persist($image12);

        $image13 = new Image;
        $image13
            ->setFile('stalefish.jpg');
            $manager->persist($image13);

        $image14 = new Image;
        $image14
            ->setFile('ollie.jpg');
            $manager->persist($image14);

        $image15 = new Image;
        $image15
            ->setFile('snowboarding.jpg');
            $manager->persist($image15);
                
            $trick = new trick();
                $trick->setName("
                Steak-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image1)
                ->addVideo($video1);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Chicken-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image2)
                ->addVideo($video2);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Roast-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image3);

                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Turkey-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image4)
                ->addVideo($video3);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Lamb-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image5)
                ->addVideo($video4);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Fish-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image6);

                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Roosbeef-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image7)
                ->addVideo($video5);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Eggs-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image8);

                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Ham-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image9)
                ->addVideo($video6);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Veal-Cutlet-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image10)
                ->addVideo($video7);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Omelet-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image11)
                ->addVideo($video8);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Salad-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image13)
                ->addVideo($video9);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Pancake-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image14)
                ->addVideo($video10);
                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Tartiflet-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image15);

                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

                $trick = new trick();
                $trick->setName("
                Cucumber-trick ")
                ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi nibh, ultricies et odio eu, suscipit accumsan ligula. Donec ut elit tortor. Nullam non placerat tellus, ac tempus ipsum. Quisque venenatis metus non eros congue, gravida fermentum leo aliquet. Morbi eget dolor eget purus tincidunt efficitur a non sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nec urna eget lorem consectetur varius convallis in nisl. Aliquam luctus augue non sapien pulvinar accumsan. Quisque non arcu suscipit, efficitur sapien sit amet, iaculis odio. Nulla aliquam risus molestie, semper felis sit amet, dignissim ante. In maximus magna vitae quam ullamcorper consectetur. Cras malesuada et justo eu finibus. Nunc sodales gravida erat. Nunc eget feugiat nibh, et dapibus neque. Donec sagittis metus id congue condimentum. Morbi vitae eros quis erat pellentesque malesuada. Fusce a lectus nec augue euismod efficitur. Phasellus condimentum ante dignissim, tempor massa non, fermentum felis. Pellentesque et sapien in odio imperdiet auctor. In hac habitasse platea dictumst. Suspendisse nulla quam, placerat quis volutpat vitae, volutpat a nulla. Donec molestie eros non arcu cursus pellentesque. Etiam non vulputate felis. Nam varius commodo neque, at molestie elit iaculis sit amet. Proin id quam turpis. Praesent molestie felis ut faucibus rhoncus. Interdum et malesuada fames ac ante ipsum primis in faucibus.")
                ->setCreationDate(new \DateTime())
                ->setCategory($category2)
                ->setUser($user)
                
                ->addImage($image12);

                $manager->persist($trick);

                for($e = 1 ; $e<=5; $e++) {
                    $comment = new Comment;
                    $comment->setTrick($trick)
                            ->setContent('Sed aliquet pharetra velit sed rhoncus. Mauris sit amet tincidunt nisl, porttitor fermentum arcu. Ut aliquam ac ligula vel faucibus.')
                            ->setCreationDate(new \DateTime())
                            ->setUser($user2);

                    $manager->persist($comment);
                }

            $manager->flush();
    }
}
