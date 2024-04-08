<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function index(ProduitRepository $repository, EntityManagerInterface $em): Response
    {   
        $produits = $repository->findAll();
        // $produits[0]->setTitle('Churoso');
        // $em->flush();

        
        return $this->render('menu/index.html.twig', compact('produits'));
    }
}
