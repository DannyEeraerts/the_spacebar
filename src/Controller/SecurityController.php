<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Form\UserRegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login",
     *  defaults={"%locale%":"en"},
     *      )
     * @Route("/{_locale}/login",
     *      name="app_login",
     *      requirements={
     *         "_locale":"en|nl",
     *     }
     *  )
     */


    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name = "app_logout", methods={"GET"})
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception('Will be intercepted before getting here');
    }

    /**
     * @Route("/register",
     *  defaults={"%locale%":"en"},
     *      )
     * @Route("/{_locale}/register",
     *      name="app_register",
     *      requirements={
     *         "_locale":"en|nl",
     *     }
     *  )
     */

    public function register(/*MailerInterface $mailer,*/ Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $formAuthenticator){

        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            /** @var User $user*/

        /*if($request->isMethod('POST'))
        {
            $user = new User;*/
            $user = $form->getData();
            /*$user->setFirstName($request->request->get('firstName'));
            $user->setLastName($request->request->get('lastName'));
            $user->setEmail($request->request->get('email'));*/
            /*$user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));*/
            $user->setPassword($passwordEncoder->encodePassword($user, $form['plainPassword']->getData()));
            if (true === $form['agreeTerms']->getData()){
                $user->agreeTerms();
            }
            $em->persist($user);
            $em->flush();

            /*$email = (new TemplatedEmail())
                ->from('danny.eeraerts@proximus')
                ->to($user->getEmail())
                ->subject('Welcome to the Space Bar!')
                ->htmlTemplate("email/welcome.html.twig");

            $mailer->send($email);*/


            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $formAuthenticator,
                'main',
            );
        }
        /*return $this->render('security/register.html.twig');*/
        return $this->render('security/register.html.twig',[
            'registrationForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/manage_account/{id}",
     *  defaults={"%locale%":"en"},
     *      )
     * @Route("/{_locale}/manage_acount/{id}",
     *      name="app_manage_account",
     *      requirements={
     *         "_locale":"en|nl",
     *     }
     *  )
     * @IsGranted("ROLE_USER",subject="user" )
     */


    public function manageAccount( Request $request, UserPasswordEncoderInterface $passwordEncoder, User $user, EntityManagerInterface $em/*, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $formAuthenticator*/)
    {
        $userId = $this->getUser()->getId();
        $urlId = intval($request->attributes->get('id'));

        if ($userId !== $urlId) {
            return $this->redirectToRoute('app_error403');
        }

        $form = $this->createForm(UserRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword($user, $form['plainPassword']->getData()));
            if (true === $form['agreeTerms']->getData()) {
                $user->agreeTerms();
            }
            $em->persist($user);
            $em->flush();

           /* $this->redirectToRoute('app_logout');*/

            $this->addFlash(
                'success',
                'Your account has been successfully updated, please login again');

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('security/manage_account.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
}
