<?php

namespace App\Controller;

use App\Dto\RechercheDto;
use App\Form\RechercheType;
use App\Entity\Favori;
use App\Form\FavoriType;
use App\Repository\FavoriRepository;
use MovieListDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieListController extends AbstractController
{
    #[Route('/movie/list/{id}', name: 'app_movie_list', methods: ["GET", "POST"])]

    public function index($id, Request $request, FavoriRepository $favoriRepository): Response
    {
        $movieApiDto = new MovieListDto();

        $recherche = new RechercheDto();
        $form = $this->createForm(RechercheType::class);

        $form->handleRequest($request);
        $data = $form->getData();
        if(!$data == null){
            $movies = $movieApiDto->getFilmsByName($data->getInput());
        }else{
            $movies = $movieApiDto->getPopular($id);
        }

        //Remplacer par page
        $categories = $movieApiDto->getCategories();

        //DD($movies);
        /*$favori = new Favori();
        $form = $this->createForm(FavoriType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            $favoriRepository->add($favori);
            return $this->redirectToRoute('app_favori', [], Response::HTTP_SEE_OTHER);
        }*/

        //--------------------------
        $favori = new Favori();
        $formFav = $this->createForm(FavoriType::class, $favori);
        $formFav->handleRequest($request);

        if ($formFav->isSubmitted() &&  $formFav->isValid()) {
            $favoriRepository->add($favori);
            return $this->redirectToRoute('app_favori', [], Response::HTTP_SEE_OTHER);
        }

        //DD($movies);
        return $this->render('movie_list/index.html.twig', [
            'controller_name' => 'MovieListController',
            'movies' => $movies ,
            'id' => $id + 1,
            'pagesPrecedente' => $id - 1,
            'controller' => $movieApiDto,
            'categories'=>$categories,
            'form'=>$form->createView(),
            'formFav' => $formFav
        ]);
    }

    #[Route('/films', name: 'filmsByName')]
    public function filmbyname(): Response
    {
        $movieAppDto = new MovieApiDto();
        //Remplacer par page
        $categorie = $movieAppDto->getCategories();
        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
            'categorie' => $categorie,
            'controller' => $movieAppDto,
        ]);
    }

    #[Route('/testpage/{idCategory}', name: 'test')]
    public function tester($idCategory): Response
    {
        $recherche = new RechercheDto();
        $form = $this->createForm(RechercheType::class,$recherche);

        $movieAppDto = new MovieListDto();
        $filmCategories = $movieAppDto->getFilmByCategoryId($idCategory,20);
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'Accueil Controller',
            'form' => $form,
            'movies' => $filmCategories,
        ]);
    }

    #[Route('/test/', name: 'test')]
    public function test($idCategory, Request $request, FavoriRepository $favoriRepository): Response
    {
        $favori = new Favori();
        $formFav = $this->createForm(FavoriType::class, $favori);
        $formFav->handleRequest($request);

        if ($formFav->isSubmitted() &&  $formFav->isValid()) {
            $favoriRepository->add($favori);
            return $this->redirectToRoute('app_favori', [], Response::HTTP_SEE_OTHER);
        }
        DD($formFav);
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'Accueil Controller',
            'formFav' => $formFav,
        ]);
    }
}
