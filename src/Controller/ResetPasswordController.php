<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ResetPasswordController extends AbstractController
{
    /**
     * @Route("/reset")
     *      defaults={"%locale%":"en"},
     *     )
     * @Route("{_locale}/reset",
     *     name="app_reset",
     *     requirements={
     *         "_locale":"en|nl",
     *     }
     * )
     */

    function resetPassword(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $encoder, CsrfTokenManagerInterface $csrfTokenManager, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $resetToken = $request->query->get('token');

        if ($request->isMethod('GET')) {
            // check user exist?
            $user = $userRepository->findOneBy(['reset_token' => $resetToken]);
            $dateExpire = $user->getExpireDateResetToken();
            $datetime = new \DateTime();
            $datetime->format('H:i:s \O\n Y-m-d');
            if ($user && ($datetime < $dateExpire) ){
                    return $this->render('security/reset_password.html.twig', );
            } else {
                $this->addFlash(
                    'notice',
                    'You are not authorized to reset the password.');
                return $this->redirectToRoute('app_error403');
            }
        }
        else{
            $this->csrfTokenManager = $csrfTokenManager;
            $plainPassword = $request->request->get('password');

            $csrfToken= $request->request->get('_csrf_token');

            if (!$this->isCsrfTokenValid('authenticate', $csrfToken))
            {
                return $this->redirectToRoute('app_error403');
            }
            $user = $userRepository->findOneBy(['reset_token' => $resetToken]);
            $user->setResetToken(null);
            $user->setExpireDateResetToken(null);
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Your password has been successfully reset, you can now log in with the new password.');

            return $this->redirectToRoute('app_login');
        }
    }

}