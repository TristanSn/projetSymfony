<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RechercheType;
use MovieListDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    #[Route('/avis/movie/{movies_id}/reviews', name: 'app_avis', methods: ["GET", "POST"])]
    public function index($movies_id, Request $request): Response
    {

        $movieApiDto = new MovieListDto();
        $form = $this->createForm(RechercheType::class);

        $form->handleRequest($request);
        $data = $form->getData();
        if(!$data == null){
            $movies = $movieApiDto->getFilmsByName($data->getInput());
        }else{
            $movies = $movieApiDto->getPopular(1);
        }

        $movie = $movieApiDto->getMoviesReview();

        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
            'movie' => $movie ,
            'movies_id' => $movies_id,
            'controller' => $movieApiDto,
        ]);
    }
}
