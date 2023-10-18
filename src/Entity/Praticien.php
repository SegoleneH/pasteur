<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\PraticienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
#[ORM\Entity(repositoryClass: PraticienRepository::class)]
class Praticien
{
    use SoftDeleteableEntity;
    use TimestampableEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 190)]
    #[ORM\Column(length: 190)]
    private ?string $nom = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 190)]
    #[ORM\Column(length: 190)]
    private ?string $prenom = null;

    #[Assert\Length(max: 190)]
    #[ORM\Column(length: 190, nullable: true)]
    private ?string $lienRdv = null;

    #[Assert\Count(min: 1, minMessage: 'Veuillez indiquer au moins 1 métier')]
    #[ORM\ManyToMany(targetEntity: Metier::class, inversedBy: 'praticiens')]
    private Collection $metiers;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Metier>
     */
    public function getMetiers(): Collection
    {
        return $this->metiers;
    }

    public function addMetier(Metier $metier): static
    {
        if (!$this->metiers->contains($metier)) {
            $this->metiers->add($metier);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): static
    {
        $this->metiers->removeElement($metier);

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
