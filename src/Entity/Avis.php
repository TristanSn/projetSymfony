<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $id_film;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFilm(): ?string
    {
        return $this->id_film;
    }

    public function setIdFilm(string $id_film): self
    {
        $this->id_film = $id_film;

        return $this;
    }
}
