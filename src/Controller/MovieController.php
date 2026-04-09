<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MovieController extends AbstractController
{
    #[Route('/movies', name: 'app_movie')]
    public function index(MovieRepository $repository): Response
    {
        $movies = $repository->findAll();
        $genres = array_unique(array_map(fn(Movie $movie) => $movie->getGenre(), $movies));
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $movies,
            'genres' => $genres,
        ]);
    }

    #[Route('/movie/new', name: 'app_movie_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($movie);
                $em->flush();
                return $this->redirectToRoute('app_movie');
            }
        return $this->render('movie/new.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/movies/genre/{genre}', name: 'app_movie_genre')]
    public function movieGenre(MovieRepository $repository, string $genre): Response
    {
        $movies = $repository->findBy(['genre' => $genre]);
        return $this->render('movie/movies_genre.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $movies,
        ]);
    }


    #[Route('/movie/{id}', name: 'app_movie_detail')]
    public function detail(MovieRepository $repository, int $id): Response
    {
        $movie = $repository->find($id);
        if (!$movie) {
            throw $this->createNotFoundException('Movie not found');
        }
        return $this->render('movie/detail.html.twig', [
            'controller_name' => 'MovieController',
            'movie' => $movie,
        ]);
    }
}
