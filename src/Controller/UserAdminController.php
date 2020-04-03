<?php


namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAdminController
{
    /**
     * @Route("admin/user/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $user = new User();
        $user->setEmail("info@jeugdverblijfdikkele.be");
        $user->setFirstName("Erwin");
        $user->setLastName("Eeraerts");
        $em->persist($user);
        $em->flush();

        return new Response(sprintf('Hiya! New user id: #%d email: %s',
            $user->getId(),
            $user->getEmail()
        ));
     }
}