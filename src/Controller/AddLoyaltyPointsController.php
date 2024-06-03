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
    public function addLoyaltyPointsForUser(User $user, Request $request, EntityManagerInterface $em, UserRepository $userRepository    ): Response
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

            if ($points > 0) {
                // Ajoutez les points de fidélité à l'utilisateur spécifié
                $user->addLoyaltyPoints($points);

                // Enregistrez les modifications dans la base de données
                $em->flush();

                // Ajoutez un message flash pour indiquer que les points ont été ajoutés avec succès
                $this->addFlash('success', 'Points de fidélité ajoutés avec succès.');

                // Redirigez vers une page appropriée, par exemple, la page de détails de l'utilisateur
                return $this->redirectToRoute('add_loyalty_points', ['id' => $user->getId()]);
            } else {
                $this->addFlash('error', 'Nombre de points invalide.');
            }
        }

        // Affichez le formulaire pour ajouter des points de fidélité à l'utilisateur spécifié
        return $this->render('user/add_points_for_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
