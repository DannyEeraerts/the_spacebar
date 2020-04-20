<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $contactFormData = $form->getData();

            $email = (new TemplatedEmail())
                ->from('danny.eeraerts@proximus')
                ->to($contactFormData['email'])
                ->subject('New message from the Space Bar!')
                ->text($contactFormData['message']);

            $mailer->send($email);

            $this->addFlash('success', 'Your contactform is successull send');

            return $this->redirectToRoute('app_contact');
            }

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
