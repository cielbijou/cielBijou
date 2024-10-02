<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomProd = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageProd = null;

    #[ORM\Column]
    private ?int $stockProd = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $prixProd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProd(): ?string
    {
        return $this->nomProd;
    }

    public function setNomProd(string $nomProd): static
    {
        $this->nomProd = $nomProd;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageProd(): ?string
    {
        return $this->imageProd;
    }

    public function setImageProd(?string $imageProd): static
    {
        $this->imageProd = $imageProd;

        return $this;
    }

    public function getStockProd(): ?int
    {
        return $this->stockProd;
    }

    public function setStockProd(int $stockProd): static
    {
        $this->stockProd = $stockProd;

        return $this;
    }

    public function getPrixProd(): ?string
    {
        return $this->prixProd;
    }

    public function setPrixProd(string $prixProd): static
    {
        $this->prixProd = $prixProd;

        return $this;
    }

}
