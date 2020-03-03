<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;

class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="role")
     */
    public function index(UserRepository $repository)
    {
        $roles = $this->getUser()->getRoles();

        if(in_array("ROLE_ADMIN", $roles)){
            $others = $repository->findAll();

        }else if(in_array("ROLE_SUPER", $roles)){
            $others = $repository->findByRol($roles);

        }else{
            $others = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy($this->getUser()->getRoles());
        }

        return $this->render('role/index.html.twig', [
            'controller_name' => 'RoleController',
            'user' => $this->getUser()->getUsername(),
            'role' => $this->getUser()->getRoles(),
            'others' => $others,
        ]);
    }
}
