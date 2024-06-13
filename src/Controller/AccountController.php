<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Form\ChangeEmailType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User; 

#[IsGranted('ROLE_USER')]
class AccountController extends AbstractController
{
    // #[Route('/account', name: 'app_account')]
    // public function index(): Response
    // {
    //     // Générer l'URL à encoder dans le code QR (par exemple, l'URL de la page account)
    //     $url = $this->generateUrl('app_account', [], UrlGeneratorInterface::ABSOLUTE_URL);

    //     // Chemin de sauvegarde du fichier du code QR
    //     $qrCodePath = '/path/to/qr_code.png'; // Chemin absolu où vous voulez enregistrer le code QR

    //     // Appel à la fonction Python pour générer le code QR
    //     exec("python3 ../bin/generate_qr_code.py $url $qrCodePath");

    //     // Rendre la vue avec le chemin du fichier du code QR
    //     return $this->render('account/index.html.twig', [
    //         'controller_name' => 'AccountController',
    //         'qr_code_path' => $qrCodePath,
    //     ]);
    // }
    #[Route('/account', name: 'app_account')]
    public function account(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangeEmailType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre email a été modifié avec succès.');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/change-email', name: 'app_account_change_email')]
    public function changeEmail(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas une instance de la classe User.');
        }

        $form = $this->createForm(ChangeEmailType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('current_password')->getData();

            if ($passwordHasher->isPasswordValid($user, $currentPassword)) {
                $user->setEmail($form->get('email')->getData()); // Mettre à jour l'email de l'utilisateur
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Votre email a été modifié avec succès.');

                return $this->redirectToRoute('app_account_change_email');
            } else {
                $this->addFlash('error', 'Le mot de passe est incorrect.');
            }
        }

        return $this->render('account/change_email.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
