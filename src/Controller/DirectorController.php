<?php

namespace App\Controller;

use App\Entity\Director;
use App\Form\DirectorType;
use App\Repository\DirectorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DirectorController extends AbstractController
{
    #[Route('/directors', name: 'app_director')]
    public function index(DirectorRepository $repository): Response
    {
        $directors = $repository->findAll();
        $filmCount = [];
        foreach ($directors as $director) {
            $filmCount[$director->getId()] = count($director->getMovies());
        }
        return $this->render('director/index.html.twig', [
            'controller_name' => 'DirectorController',
            'directors' => $directors,
            'filmCount' => $filmCount,
        ]);
    }

    #[Route('/director/new', name: 'app_director_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $director = new Director();
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($director);
                $em->flush();
                return $this->redirectToRoute('app_director');
            }
        return $this->render('director/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/director/{id}', name: 'app_director_detail')]
    public function detail(DirectorRepository $repository, int $id): Response
    {
        $director = $repository->find($id);
        if (!$director) {
            throw $this->createNotFoundException('Director not found');
        }
        return $this->render('director/detail.html.twig', [
            'controller_name' => 'DirectorController',
            'director' => $director,
        ]);
    }

}
