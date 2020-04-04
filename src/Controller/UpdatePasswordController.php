<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UpdatePasswordController extends AbstractController
{
    private $passwordEncoder;

    public function __construct (UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("update/password")
     */

    public function update(EntityManagerInterface $em)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(3);

        if (!$user) {
            throw $this->createNotFoundException(
                'User found for id '.$this->getUser()
            );
        }
        $user->setPassword($this->passwordEncoder->encodePassword($user, '1234Erwin'));
        $em->flush();

        return new Response(sprintf('Hiya! New password for user: #%s password: %s',
            $user->getUsername(),
            $user->getPassword()
        ));
    }

}