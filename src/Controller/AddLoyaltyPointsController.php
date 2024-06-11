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
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AddLoyaltyPointsController extends AbstractController
{
    // Injectez FormFactoryInterface dans le constructeur
    public function __construct(private FormFactoryInterface $formFactory) {}

    #[Route('/admin/user/{id}/add-loyalty-points', name: 'add_loyalty_points_user')]
    public function addLoyaltyPointsForUser(User $user, Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {   
        // Récupérer tous les utilisateurs
        $users = $userRepository->findAll();
        
        // Créez le formulaire
        $form = $this->createForm(LoyaltyPointsType::class, null, [
            'users' => $users,
        ]);

        // Traitez la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $points = $data['points'];
            $action = $request->request->get('action'); // Récupérer l'action du formulaire

            if ($points > 0) {
                if ($action === 'add') {
                    // Ajoutez les points de fidélité à l'utilisateur spécifié
                    $user->addLoyaltyPoints($points);
                    $this->addFlash('success', 'Points de fidélité ajoutés avec succès.');
                } elseif ($action === 'deduct') {
                    // Enlevez les points de fidélité à l'utilisateur spécifié
                    $user->deductLoyaltyPoints($points);
                    $this->addFlash('success', 'Points de fidélité enlevés avec succès.');
                }

                // Enregistrez les modifications dans la base de données
                $em->flush();

                // Redirigez vers une page appropriée, par exemple, la page de détails de l'utilisateur
                return $this->redirectToRoute('add_loyalty_points_user', ['id' => $user->getId()]);
            } else {
                $this->addFlash('error', 'Nombre de points invalide.');
            }
        }

        // Affichez le formulaire pour ajouter ou enlever des points de fidélité à l'utilisateur spécifié
        return $this->render('user/add_points_for_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/admin/user/{id}/add-loyalty-points/drink', name: 'add_loyalty_points_drink')]
    public function addLoyaltyPointsForDrink(User $user, Request $request, EntityManagerInterface $em): Response
    {
         // Soustraire un certain nombre de points de fidélité pour la récompense alimentaire
         $pointsToDeduct = 40; // Par exemple, soustraire 10 points
         $user->deductLoyaltyPoints($pointsToDeduct);
 
         // Enregistrez les modifications dans la base de données
         $em->flush();

         // Ajoutez un message flash de succès
        $this->addFlash('success', 'Points de fidélité enlevés avec succès.');
 
         // Redirigez vers une page appropriée, par exemple, la page de détails de l'utilisateur
         return $this->redirectToRoute('add_loyalty_points_user', ['id' => $user->getId()]);
    }

    #[Route('/admin/user/{id}/add-loyalty-points/food', name: 'add_loyalty_points_food')]
    public function addLoyaltyPointsForFood(User $user, Request $request, EntityManagerInterface $em): Response
    {
         // Soustraire un certain nombre de points de fidélité pour la récompense alimentaire
         $pointsToDeduct = 60; // Par exemple, soustraire 10 points
         $user->deductLoyaltyPoints($pointsToDeduct);
 
         // Enregistrez les modifications dans la base de données
         $em->flush();
         
         // Ajoutez un message flash de succès
        $this->addFlash('success', 'Points de fidélité enlevés avec succès.');
 
         // Redirigez vers une page appropriée, par exemple, la page de détails de l'utilisateur
         return $this->redirectToRoute('add_loyalty_points_user', ['id' => $user->getId()]);
    }

    #[Route('/admin/user/{id}/add-loyalty-points/menu', name: 'add_loyalty_points_menu')]
    public function addLoyaltyPointsForMenu(User $user, Request $request, EntityManagerInterface $em): Response
    {
         // Soustraire un certain nombre de points de fidélité pour la récompense alimentaire
         $pointsToDeduct = 80; // Par exemple, soustraire 10 points
         $user->deductLoyaltyPoints($pointsToDeduct);
 
         // Enregistrez les modifications dans la base de données
         $em->flush();

         // Ajoutez un message flash de succès
        $this->addFlash('success', 'Points de fidélité enlevés avec succès.');
 
         // Redirigez vers une page appropriée, par exemple, la page de détails de l'utilisateur
         return $this->redirectToRoute('add_loyalty_points_user', ['id' => $user->getId()]);
    }

    #[Route('/admin/user/{id}/add-loyalty-points/vip', name: 'add_loyalty_points_vip')]
    public function addLoyaltyPointsForVIP(User $user, Request $request, EntityManagerInterface $em): Response
    {
         // Soustraire un certain nombre de points de fidélité pour la récompense alimentaire
         $pointsToDeduct = 100; // Par exemple, soustraire 10 points
         $user->deductLoyaltyPoints($pointsToDeduct);
 
         // Enregistrez les modifications dans la base de données
         $em->flush();

         // Ajoutez un message flash de succès
        $this->addFlash('success', 'Points de fidélité enlevés avec succès.');
 
         // Redirigez vers une page appropriée, par exemple, la page de détails de l'utilisateur
         return $this->redirectToRoute('add_loyalty_points_user', ['id' => $user->getId()]);
    }
}
