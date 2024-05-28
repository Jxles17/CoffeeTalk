<?php 

// src/Controller/LoyaltyPointsController.php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoyaltyPointsType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoyaltyPointsController extends AbstractController
{
    #[Route('/admin/user/add-loyalty-points', name: 'add_loyalty_points')]
    public function addLoyaltyPoints(Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        // Récupérer tous les utilisateurs
        $users = $userRepository->findAll();

        // Traiter la soumission du formulaire
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $points = (int) $request->request->get('points');

            // Récupérer l'utilisateur correspondant
            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user && $points > 0) {
                // Ajouter les points de fidélité à l'utilisateur sélectionné
                $user->addLoyaltyPoints($points);

                // Enregistrer les modifications dans la base de données
                $em->flush();

                // Ajouter un message flash pour indiquer que les points ont été ajoutés avec succès
                $this->addFlash('success', 'Points de fidélité ajoutés avec succès.');
            } else {
                $this->addFlash('error', 'Utilisateur non trouvé ou nombre de points invalide.');
            }

            // Rediriger vers la page d'administration ou une autre page appropriée
            return $this->redirectToRoute('add_loyalty_points');
        }

        // Afficher le formulaire
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
