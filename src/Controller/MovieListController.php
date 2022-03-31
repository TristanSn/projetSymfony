<?php

namespace App\Controller;

use App\Entity\Favori;
use App\Form\FavoriType;
use App\Repository\FavoriRepository;
use MovieListDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieListController extends AbstractController
{
    #[Route('/movie/list/{id}', name: 'app_movie_list', methods: ["GET", "POST"])]

    public function index($id, Request $request, FavoriRepository $favoriRepository): Response
    {
        $movieApiDto = new MovieListDto();
        $moviesPage = $movieApiDto->getPopular($id);

        $favori = new Favori();
        $form = $this->createForm(FavoriType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            $favoriRepository->add($favori);
            return $this->redirectToRoute('app_favori', [], Response::HTTP_SEE_OTHER);
        }

        //DD($moviesPage);
        return $this->render('movie_list/index.html.twig', [
            'controller_name' => 'MovieListController',
            'movies' => $moviesPage,
            'id' => $id + 1,
            'pagesPrecedente' => $id - 1,
            'form' => $form
        ]);
    }
}
