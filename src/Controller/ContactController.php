<?php

namespace App\Controller;

use CodeItNow\BarcodeBundle\Utils\QrCode;
use App\Form\ContactFormType;
use Knp\Snappy\Pdf;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ContactController extends AbstractController
{

    private $pdf;
    private $twig;

    /**
     * @Route("/contact",
     *  defaults={"%locale%":"en"},
     *      )
     * @Route("/{_locale}/contact",
     *      name="app_contact",
     *      requirements={
     *         "_locale":"en|nl",
     *     }
     *  )
     */

    public function contact(Request $request, MailerInterface $mailer, Environment $twig, Pdf $pdf)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $contactFormData = $form->getData();
            $firstName = $contactFormData['firstName'];
            $fullName= $contactFormData['firstName'].' '.$contactFormData['Lastname'];
            $email = $contactFormData['email'];


            $reservationCode= bin2hex(random_bytes(20));
            $qrCode = $this->createQRCode($reservationCode);
            /*$qrCode = new QrCode();
            $qrCode
                ->setText($reservationCode)
                ->setSize(200)
                ->setPadding(12)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabelFontSize(16)
                ->setImageType(QrCode::IMAGE_TYPE_PNG)
            ;*/

            $type = $qrCode->getContentType();
            $code = $qrCode->generate();
            $imageQR = 'data:'.$type.';base64,'.$code;

            $this->twig = $twig;
            $this->pdf = $pdf;

            $html = $this->twig->render('pdf/ticket.html.twig',[
                'firstName' => $firstName,
                'fullName' => $fullName,
                'email' => $email,
                'imageQR' => $imageQR,
                'reservationCode' => $reservationCode,
            ]);
            $pdf = $this->pdf->getOutputFromHtml($html);

            $email = (new TemplatedEmail())
                ->from('danny.eeraerts@proximus')
                ->to($contactFormData['email'])
                ->subject('New message from the Space Bar!')
                ->text($contactFormData['message'])
                ->attach($pdf);

            $mailer->send($email);

            $this->addFlash('success', 'Your contactform is successull send.');

            return $this->redirectToRoute('app_contact');
            }

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }

    private function createQrCode($reservationCode){
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
        return $qrCode;
    }
}
