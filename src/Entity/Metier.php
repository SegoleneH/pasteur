<?php

namespace App\Entity;

use App\Repository\MetierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
#[ORM\Entity(repositoryClass: MetierRepository::class)]
class Metier
{
    use SoftDeleteableEntity;
    use TimestampableEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 190)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Praticien::class, mappedBy: 'metiers')]
    private Collection $praticiens;

    public function __construct()
    {
        $this->praticiens = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Praticien>
     */
    public function getPraticiens(): Collection
    {
        return $this->praticiens;
    }

    public function addPraticien(Praticien $praticien): static
    {
        if (!$this->praticiens->contains($praticien)) {
            $this->praticiens->add($praticien);
            $praticien->addMetier($this);
        }

        return $this;
    }

    public function removePraticien(Praticien $praticien): static
    {
        if ($this->praticiens->removeElement($praticien)) {
            $praticien->removeMetier($this);
        }

        return $this;
    }
}
