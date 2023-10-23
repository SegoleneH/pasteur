<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[Gedmo\SoftDeleteable(fieldName:"deletedAt", timeAware:false, hardDelete:false)]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[Vich\Uploadable]
class Article
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
    private ?string $titre = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 190)]
    #[ORM\Column(length: 190)]
    private ?string $resume = null;

    #[Assert\Length(max: 10000)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'articles')]
    private Collection $tags;


    #[ORM\ManyToMany(targetEntity: Editeur::class, mappedBy: 'articles')]
    private Collection $editeurs;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(length: 190, nullable: true)]
    private ?string $alt = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->editeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addArticle($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Editeur>
     */
    public function getEditeurs(): Collection
    {
        return $this->editeurs;
    }

    public function addEditeur(Editeur $editeur): static
    {
        if (!$this->editeurs->contains($editeur)) {
            $this->editeurs->add($editeur);
            $editeur->addArticle($this);
        }

        return $this;
    }

    public function removeEditeur(Editeur $editeur): static
    {
        if ($this->editeurs->removeElement($editeur)) {
            $editeur->removeArticle($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }
}
