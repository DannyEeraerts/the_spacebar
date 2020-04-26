<?php


namespace App\Controller;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    /**
     * @Route("/ticket", name="app_ticket")
     * @throws \Exception
     */

    public function renderPDF (Request $request) {

        $firstName = 'Danny';
        $fullName = 'Danny Eeraerts';
        $email = 'danny.eeraerts@proximus.be';
        $reservationCode= bin2hex(random_bytes(20));

        $qrCode = new QrCode();
        $qrCode
            ->setText($reservationCode)
            ->setSize(200)
            ->setPadding(12)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG)
        ;

        $type = $qrCode->getContentType();
        $code = $qrCode->generate();
        $imageQR = 'data:'.$type.';base64,'.$code;

        return $this->render('pdf/ticket.html.twig', [
            'firstName' => $firstName,
            'fullName' => $fullName,
            'email' => $email,
            'imageQR' => $imageQR,
            'reservationCode' => $reservationCode,
        ]);
    }

}