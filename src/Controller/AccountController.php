<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        // Générer l'URL à encoder dans le code QR (par exemple, l'URL de la page account)
        $url = $this->generateUrl('app_account', [], UrlGeneratorInterface::ABSOLUTE_URL);

        // Chemin de sauvegarde du fichier du code QR
        $qrCodePath = '/path/to/qr_code.png'; // Chemin absolu où vous voulez enregistrer le code QR

        // Appel à la fonction Python pour générer le code QR
        exec("python3 ../bin/generate_qr_code.py $url $qrCodePath");

        // Rendre la vue avec le chemin du fichier du code QR
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'qr_code_path' => $qrCodePath,
        ]);
    }
}
