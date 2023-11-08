<?php

namespace App\Entity;

use App\Repository\MentionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MentionsRepository::class)]
class Mentions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank (message:'Veuillez entrer du contenu pour votre article.')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $mentionsLegale = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMentionsLegale(): ?string
    {
        return $this->mentionsLegale;
    }

    public function setMentionsLegale(string $mentionsLegale): static
    {
        $this->mentionsLegale = $mentionsLegale;

        return $this;
    }
}
