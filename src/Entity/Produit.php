<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column]
    private ?float  $prixProd = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'unProduit')]
    private Collection $commentaires;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $uneCategorie = null;

    /**
     * @var Collection<int, LigneCommande>
     */
    #[ORM\OneToMany(targetEntity: LigneCommande::class, mappedBy: 'unProduit')]
    private Collection $ligneCommandes;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
    }

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

    public function getPrixProd(): ?float 
    {
        return $this->prixProd;
    }

    public function setPrixProd(?float  $prixProd): static
    {
        $this->prixProd = $prixProd;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setUnProduit($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUnProduit() === $this) {
                $commentaire->setUnProduit(null);
            }
        }

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

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): static
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->add($ligneCommande);
            $ligneCommande->setUnProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): static
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getUnProduit() === $this) {
                $ligneCommande->setUnProduit(null);
            }
        }

        return $this;
    }

}
