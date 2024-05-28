<?php

// src/Controller/DashboardController.php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function index(
        UserRepository $userRepository,
        ProduitRepository $produitRepository,
        EventRepository $eventRepository,
        EntityManagerInterface $em
    ): Response {
        // Statistiques
        $totalUsers = $userRepository->count([]);
        $totalProducts = $produitRepository->count([]);
        $totalEvents = $eventRepository->count([]);
        $newUsersThisMonth = $userRepository->countNewUsersThisMonth();

        // Activités Récentes
        $recentUsers = $userRepository->findBy([], ['createdAt' => 'DESC'], 5);
        $recentProducts = $produitRepository->findBy([], ['createdAt' => 'DESC'], 5);
        $recentEvents = $eventRepository->findBy([], ['createdAt' => 'DESC'], 5);

        return $this->render('/dashboard.html.twig', [
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'totalEvents' => $totalEvents,
            'newUsersThisMonth' => $newUsersThisMonth,
            'recentUsers' => $recentUsers,
            'recentProducts' => $recentProducts,
            'recentEvents' => $recentEvents,
        ]);
    }
}
