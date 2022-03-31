<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $movieid;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $moviename;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $moviedescription;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $moviecomment;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $moviepicture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieid(): ?int
    {
        return $this->movieid;
    }

    public function setMovieid(?int $movieid): self
    {
        $this->movieid = $movieid;

        return $this;
    }

    public function getMoviename(): ?string
    {
        return $this->moviename;
    }

    public function setMoviename(?string $moviename): self
    {
        $this->moviename = $moviename;

        return $this;
    }

    public function getMoviedescription(): ?string
    {
        return $this->moviedescription;
    }

    public function setMoviedescription(?string $moviedescription): self
    {
        $this->moviedescription = $moviedescription;

        return $this;
    }

    public function getMoviecomment(): ?string
    {
        return $this->moviecomment;
    }

    public function setMoviecomment(?string $moviecomment): self
    {
        $this->moviecomment = $moviecomment;

        return $this;
    }

    public function getMoviepicture(): ?string
    {
        return $this->moviepicture;
    }

    public function setMoviepicture(?string $moviepicture): self
    {
        $this->moviepicture = $moviepicture;

        return $this;
    }
}
