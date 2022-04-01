<?php

namespace App\Entity;

use App\Repository\FavoriRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriRepository::class)]
class Favori
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $idFilm;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFilm(): ?string
    {
        return $this->idFilm;
    }

    public function setIdFilm(?string $idFilm): self
    {
        $this->idFilm = $idFilm;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(?string $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
