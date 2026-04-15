<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRepository;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ],
    normalizationContext: ['groups' => ['movie:read']],
)]
#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiFilter(SearchFilter::class, properties: [
    'genre' => 'exact',
    'director' => 'exact',
])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('movie:read')]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(max: 150)]
    #[Groups(['director:read', 'movie:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['movie:read'])]
    private ?string $synopsis = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'L\'année de sortie est obligatoire.')]
    #[Assert\GreaterThan(1900, message: 'L\'année de sortie doit être supérieure à 1900.')]
    #[Assert\LessThanOrEqual(value: 2026, message: 'L\'année de sortie doit être inférieure ou égale à 2026.')]
    #[Groups(['director:read', 'movie:read'])]
    private ?int $releaseYear = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le genre est obligatoire.')]
    #[Groups(['movie:read'])]
    private ?string $genre = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le réalisateur est obligatoire.')]
    #[Groups(['movie:read'])]
    private ?Director $director = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): static
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDirector(): ?Director
    {
        return $this->director;
    }

    public function setDirector(?Director $director): static
    {
        $this->director = $director;

        return $this;
    }
}
