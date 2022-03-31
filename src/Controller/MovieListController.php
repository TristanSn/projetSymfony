<?php

namespace App\Controller;

use MovieListDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieListController extends AbstractController
{
    #[Route('/movie/list/{id}', name: 'app_movie_list', methods: ["GET", "POST"])]

    public function index($id): Response
    {
        $movieApiDto = new MovieListDto();
        $moviesPage = $movieApiDto->getPopular($id);

        //DD($moviesPage);
        return $this->render('movie_list/index.html.twig', [
            'controller_name' => 'MovieListController',
            'movies' => $moviesPage,
            'id' => $id + 1,
            'pagesPrecedente' => $id - 1
        ]);
    }
}
