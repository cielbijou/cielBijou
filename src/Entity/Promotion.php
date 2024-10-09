<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebutPromo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFinPromo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 2)]
    private ?string $remisePromo = null;

    #[ORM\ManyToOne(inversedBy: 'promotions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $uneCategorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutPromo(): ?\DateTimeInterface
    {
        return $this->dateDebutPromo;
    }

    public function setDateDebutPromo(\DateTimeInterface $dateDebutPromo): static
    {
        $this->dateDebutPromo = $dateDebutPromo;

        return $this;
    }

    public function getDateFinPromo(): ?\DateTimeInterface
    {
        return $this->dateFinPromo;
    }

    public function setDateFinPromo(\DateTimeInterface $dateFinPromo): static
    {
        $this->dateFinPromo = $dateFinPromo;

        return $this;
    }

    public function getRemisePromo(): ?string
    {
        return $this->remisePromo;
    }

    public function setRemisePromo(string $remisePromo): static
    {
        $this->remisePromo = $remisePromo;

        return $this;
    }

    public function getUneCategorie(): ?Categorie
    {
        return $this->uneCategorie;
    }

    public function setUneCategorie(?Categorie $uneCategorie): static
    {
        $this->uneCategorie = $uneCategorie;

        return $this;
    }
}
