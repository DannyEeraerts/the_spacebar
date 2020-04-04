<?php


namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserAdminController
{
    private $passwordEncoder;

    public function __construct (UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("admin/user/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $user = new User();
        $user->setEmail("info@jeugdverblijfdikkele.be");
        $user->setFirstName("Erwin");
        $user->setLastName("Eeraerts");
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, '1234Erwin'
        ));
        $em->persist($user);
        $em->flush();

        return new Response(sprintf('Hiya! New user id: #%d email: %s',
            $user->getId(),
            $user->getEmail()
        ));
     }
}