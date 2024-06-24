<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;

class MenuController extends AbstractController
{
    #[Route('/menu-tapas', name: 'menu_tapas')]
    public function menuTapas(ProduitRepository $produitRepository): Response
    {
        // Récupérer les produits avec la catégorie 'tapas'
        $produits = $produitRepository->findBy(['categorie' => 'tapas']);

        return $this->render('menu/tapas.html.twig', [
            'produits' => $produits,
            'category' => 'Tapas',
        ]);
    }

    #[Route('/menu-boisson', name: 'menu_boisson')]
    public function menuBoissons(ProduitRepository $produitRepository): Response
    {
        // Récupérer les produits avec la catégorie 'boisson'
        $produits = $produitRepository->findBy(['categorie' => 'boisson']);

        return $this->render('menu/boisson.html.twig', [
            'produits' => $produits,
            'category' => 'Boissons',
        ]);
    }

    #[Route('/menu-dessert', name: 'menu_dessert')]
    public function menuDesserts(ProduitRepository $produitRepository): Response
    {
        // Récupérer les produits avec la catégorie 'dessert'
        $produits = $produitRepository->findBy(['categorie' => 'dessert']);

        return $this->render('menu/dessert.html.twig', [
            'produits' => $produits,
            'category' => 'Desserts',
        ]);
    }
}
