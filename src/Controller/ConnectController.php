<?php

namespace App\Controller;

use App\Form\ConnectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class ConnectController extends AbstractController
{

    #[Route('/connect', name: 'app_connect', methods: ["GET", "POST"])]
    public function index(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(ConnectType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()) {


            return $this->redirectToRoute('app_acceuil');
        }

        return $this->render('connect/index.html.twig', [
            'controller_name' => 'ConnectController',
            'form' => $form->createView()
        ]);
    }
}
