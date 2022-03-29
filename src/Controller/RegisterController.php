<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $task = new User();
        $form = $this->createForm(RegisterType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $plaintextPassword = $task->getPassword();
            $hashedPassword = $passwordEncoder->hashPassword(
                $task,
                $plaintextPassword
            );

            $task->setMail($task->getMail());
            $task->setUsername($task->getUsername());
            $task->setPassword($hashedPassword);

            $entityManagerInterface->persist($task);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('acceuil');
        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'form' => $form->createView(),
        ]);
    }
}
