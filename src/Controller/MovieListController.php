<?php

namespace App\Controller;

use App\Dto\RechercheDto;
use App\Entity\Avis;
use App\Entity\User;
use App\Form\AvisType;
use App\Form\RechercheType;
use App\Entity\Favori;
use App\Form\FavoriType;
use App\Repository\AvisRepository;
use App\Repository\FavoriRepository;
use Doctrine\ORM\EntityManagerInterface;
use MovieListDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieListController extends AbstractController
{
    #[Route('/movie/list/{id}', name: 'app_movie_list', methods: ["GET", "POST"])]

    public function index($id, Request $request, FavoriRepository $favoriRepository, AvisRepository $avisRepository): Response
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

        $categories = $movieApiDto->getCategories();

        //DD($movies);
        $favori = new Favori();
        $user = $this->getUser();
        /*$form = $this->createForm(FavoriType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            $favoriRepository->add($favori);
            return $this->redirectToRoute('app_favori', [], Response::HTTP_SEE_OTHER);
        }*/

        //--------------------------
        /*$favori = new Favori();*/

        $formFav = $this->createForm(FavoriType::class, $favori);
        $formFav->handleRequest($request);

        if ($formFav->isSubmitted() &&  $formFav->isValid()) {
            $favoriRepository->add($favori);
            return $this->redirectToRoute('app_favori', [
                'movies_id' => $favori->getIdFilm()
            ], Response::HTTP_SEE_OTHER);
        }

        $avis = new Avis();

        $formAvis = $this->createForm(AvisType::class, $avis);
        $formAvis->handleRequest($request);

        if ($formAvis->isSubmitted() &&  $formAvis->isValid()) {
            return $this->redirectToRoute('app_avis', [
                'movies_id' => $avis->getIdFilm()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie_list/index.html.twig', [
            'controller_name' => 'MovieListController',
            'movies' => $movies ,
            'id' => $id + 1,
            'pagesPrecedente' => $id - 1,
            'controller' => $movieApiDto,
            'categories'=>$categories,
            'form'=>$form->createView(),
            'formFav' => $formFav,
            'formAvis' => $formAvis,
            'user' => $user
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
