<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User; // Assurez-vous que cette classe est correctement importée.
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class QrCodeController extends AbstractController
{
    #[Route('/user/{id}/qr-code', name:"user_qr_code")]
    public function showUserQrCode(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id '.$id);
        }

        $qrCode = QrCode::create($user->getQrData())
            ->setSize(300)
            ->setMargin(10)
            ->setEncoding(new Encoding('UTF-8')) // Utilisation de la classe Encoding pour définir l'encodage
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
            ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255]);

        $writer = new PngWriter();
        $pngData = $writer->write($qrCode)->getDataUri();

        // Passer le Data URI à Twig
        return $this->render('qr_code/show.html.twig', [
            'qrCodeImage' => $pngData
        ]);
    }
}