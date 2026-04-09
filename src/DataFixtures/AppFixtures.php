<?php

namespace App\DataFixtures;

use App\Entity\Director;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $directors = [
            [
                'firstName' => 'Christopher',
                'lastName' => 'Nolan',
                'nationality' => 'Britannique',
            ],
            [
                'firstName' => 'Greta',
                'lastName' => 'Gerwig',
                'nationality' => 'Américaine',
            ],
            [
                'firstName' => 'Hayao',
                'lastName' => 'Miyazaki',
                'nationality' => 'Japonaise',
            ],
            [
                'firstName' => 'Denis',
                'lastName' => 'Villeneuve',
                'nationality' => 'Canadienne',
            ],
        ];
        
        foreach ($directors as $data) {
            $director = new Director();
            $director->setFirstName($data['firstName']);
            $director->setLastName($data['lastName']);
            $director->setNationality($data['nationality']);
            $manager->persist($director);
            $this->addReference('director-' . $data['lastName'], $director);
        }
        
        
        $movies = [
            [
                'title' => 'Inception',
                'releaseYear' => 2010,
                'genre' => 'Science-fiction',
                'synopsis' => 'Un voleur spécialisé dans l\'extraction de secrets enfouis dans les rêves se voit confier la tâche inverse : implanter une idée.',
                'director' => 'Nolan',
            ],
            [
                'title' => 'The Dark Knight',
                'releaseYear' => 2008,
                'genre' => 'Action',
                'synopsis' => 'Batman affronte le Joker, un criminel anarchiste qui sème le chaos à Gotham City.',
                'director' => 'Nolan',
            ],
            [
                'title' => 'Interstellar',
                'releaseYear' => 2014,
                'genre' => 'Science-fiction',
                'synopsis' => 'Un groupe d\'explorateurs voyage à travers un trou de ver pour assurer la survie de l\'humanité.',
                'director' => 'Nolan',
            ],
            [
                'title' => 'Barbie',
                'releaseYear' => 2023,
                'genre' => 'Comédie',
                'synopsis' => 'Barbie et Ken quittent Barbieland pour explorer le monde réel et découvrir ce que signifie être humain.',
                'director' => 'Gerwig',
            ],
            [
                'title' => 'Lady Bird',
                'releaseYear' => 2017,
                'genre' => 'Drame',
                'synopsis' => 'Une lycéenne de Sacramento rêve de quitter sa ville natale et navigue entre amours, amitiés et conflits familiaux.',
                'director' => 'Gerwig',
            ],
            [
                'title' => 'Le Voyage de Chihiro',
                'releaseYear' => 2001,
                'genre' => 'Animation',
                'synopsis' => 'Une fillette se retrouve piégée dans un monde fantastique peuplé de dieux et d\'esprits, et doit travailler pour libérer ses parents.',
                'director' => 'Miyazaki',
            ],
            [
                'title' => 'Mon Voisin Totoro',
                'releaseYear' => 1988,
                'genre' => 'Animation',
                'synopsis' => 'Deux sœurs s\'installent à la campagne et se lient d\'amitié avec Totoro, une créature forestière magique.',
                'director' => 'Miyazaki',
            ],
            [
                'title' => 'Dune',
                'releaseYear' => 2021,
                'genre' => 'Science-fiction',
                'synopsis' => 'Un jeune noble est propulsé dans une guerre pour le contrôle de la planète désertique Arrakis, seule source d\'une ressource vitale.',
                'director' => 'Villeneuve',
            ],
            [
                'title' => 'Blade Runner 2049',
                'releaseYear' => 2017,
                'genre' => 'Science-fiction',
                'synopsis' => 'Un blade runner découvre un secret enfoui qui pourrait plonger la société dans le chaos, et part à la recherche de Rick Deckard.',
                'director' => 'Villeneuve',
            ],
        ];

        foreach ($movies as $data) {
            $movie = new Movie();
            $movie->setTitle($data['title']);
            $movie->setReleaseYear($data['releaseYear']);
            $movie->setGenre($data['genre']);
            $movie->setSynopsis($data['synopsis']);
            $movie->setDirector($this->getReference('director-' . $data['director'], Director::class));
                
            $manager->persist($movie);
            }



        $manager->flush();
    }
}
