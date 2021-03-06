<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RechercheType;
use MovieListDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriController extends AbstractController
{
    #[Route('/favori/movie/{movies_id}', name: 'app_favori', methods: ["GET", "POST"])]
    public function index($movies_id, Request $request): Response
    {
        $user = new User();
        $user->getFavori();
        $movieApiDto = new MovieListDto();
        $form = $this->createForm(RechercheType::class);

        $form->handleRequest($request);
        $data = $form->getData();
        if(!$data == null){
            $movies = $movieApiDto->getFilmsByName($data->getInput());
        }else{
            $movies = $movieApiDto->getPopular(1);
        }

        $movie = $movieApiDto->getFilmById($movies_id);

        return $this->render('favori/index.html.twig', [
            'controller_name' => 'FavoriController',
            'movies' => $movies ,
            'movie' => $movie ,
            'movies_id' => $movies_id,
            'controller' => $movieApiDto,
            'form'=>$form->createView(),
        ]);
    }
}
