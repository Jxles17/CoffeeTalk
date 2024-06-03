<?php 

// src/Controller/LoyaltyPointsController.php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class LoyaltyPointsController extends AbstractController
{
    #[Route('/admin/user/add-loyalty-points', name: 'add_loyalty_points')]
    public function addLoyaltyPoints(Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $points = (int) $request->request->get('points');
            $action = $request->request->get('action'); // New field to determine action

            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user && $points > 0) {
                if ($action === 'add') {
                    $user->addLoyaltyPoints($points);
                    $this->addFlash('success', 'Points de fidélité ajoutés avec succès.');
                } elseif ($action === 'deduct') {
                    $user->deductLoyaltyPoints($points);
                    $this->addFlash('success', 'Points de fidélité déduits avec succès.');
                }
                $em->flush();
            } else {
                $this->addFlash('error', 'Utilisateur non trouvé ou nombre de points invalide.');
            }

            return $this->redirectToRoute('add_loyalty_points');
        }

        return $this->render('user/add_loyalty_points.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/usersearch', name: 'user_list', methods: ['GET'])]
    public function getUserSearch(Request $request, UserRepository $userRepository): Response
    {
        $search = $request->query->get('search', '');
        $users = $userRepository->findBySearch($search);

        return $this->render('user/add_loyalty_points.html.twig', [
            'users' => $users
        ]);
    }
}
