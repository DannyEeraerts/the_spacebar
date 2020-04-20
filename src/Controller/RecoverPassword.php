<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class RecoverPassword extends AbstractController
{

    /**
     * @Route("/recoverpassword", name="app_recover_password")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function reset_password_mail(Request $request, UserRepository $userRepository, CsrfTokenManagerInterface $csrfTokenManager, MailerInterface $mailer){

        $this->userRepository = $userRepository;
        $this->csrfTokenManager = $csrfTokenManager;
        $error = "";


        if ($request->isMethod('post')) {
            $emailAddress= $request->request->get('resetEmail');

            if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                $error = "This is not a valid email format";
                return $this->render('security/recover_password.html.twig', [
                    'error' => $error
                ]);
            }

            $token= $request->request->get('_csrf_token');
            // 'authenticate' is the same value used in the template to generate the token

            if (!$this->isCsrfTokenValid('authenticate', $token))
            {
                return $this->redirectToRoute('app_error403');
            }

            // check user exist?
            $user = $userRepository->findOneBy(['email' => $emailAddress]);

            if ($user)
            {
                $resetToken = $this->generateResetToken();
                $expireDate = $this->expireDate();

                $em = $this->getDoctrine()->getManager();
                $user->setResetToken($resetToken);
                $user->setExpireDateResetToken($expireDate);
                $em->persist($user);
                $em->flush();

                $firstName = $user->getFirstName();
                $token = $user->getResetToken();
                $expire = $user->getExpireDateResetToken();
                $year = new \DateTime();
                $year->format('Y');



                // Mail
                $email = (new TemplatedEmail())
                    ->from('danny.eeraerts@proximus')
                    ->to($user->getEmail())
                    ->subject('Reset password for the Space Bar!')
                    ->htmlTemplate('Email/reset_email.html.twig')
                    ->context([
                        'firstName' =>$firstName,
                        'expire' => $expire,
                        'emailAddress' => $emailAddress,
                        'token' => $token,
                        'year' => $year,
                    ]);

                $mailer->send($email);


                $this->addFlash('success', 'Consult your mail. There is an email with instructions on how to restore
                    your password');

                return $this->redirectToRoute('app_homepage');

            }
            // eerst real reset maken.
            else {
                $this->addFlash(
                    'notice',
                    'Dit e-mailadres komt niet voor in ons systeem. Maak een nieuwe account');
                return $this->redirectToRoute('app_recover_password');
            }
        }
        return $this->render('security/recover_password.html.twig', [
            'error' => $error
        ]);
    }

    public function generateResetToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    public function expireDate()
    {
        $datetime = new \DateTime();
        $datetime->format('H:i:s \O\n Y-m-d');
        $datetime->modify('+3 hours');
        return ($datetime);
    }
}