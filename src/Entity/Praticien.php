<?php

namespace App\Entity;

use App\Repository\PraticienRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PraticienRepository::class)]
class Praticien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 190)]
    private ?string $nom = null;

    #[ORM\Column(length: 190)]
    private ?string $prenom = null;

    #[ORM\Column(length: 190, nullable: true)]
    private ?string $lienRdv = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getLienRdv(): ?string
    {
        return $this->lienRdv;
    }

    public function setLienRdv(?string $lienRdv): static
    {
        $this->lienRdv = $lienRdv;

        return $this;
    }
}
