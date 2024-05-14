<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ProduitRepository $repository): Response
    {   
        // $user = new User();
        // $user->setEmail('julesherve@gmail.com')
        //     ->setUsername('julesherve')
        //     ->setPassword($hasher->hashPassword($user, '0000'))
        //     ->setRoles([]);
        // $em->persist($user);
        // $em->flush();
        return $this->render('home/index.html.twig');
    }
}
