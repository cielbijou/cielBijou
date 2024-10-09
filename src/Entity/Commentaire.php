<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCommentaire = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statusCommentaire = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenuCommentaire = null;

    #[ORM\Column(nullable: true)]
    private ?int $noteCommentaire = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $unProduit = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $unClient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->dateCommentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $dateCommentaire): static
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    public function isStatusCommentaire(): ?bool
    {
        return $this->statusCommentaire;
    }

    public function setStatusCommentaire(?bool $statusCommentaire): static
    {
        $this->statusCommentaire = $statusCommentaire;

        return $this;
    }

    public function getContenuCommentaire(): ?string
    {
        return $this->contenuCommentaire;
    }

    public function setContenuCommentaire(string $contenuCommentaire): static
    {
        $this->contenuCommentaire = $contenuCommentaire;

        return $this;
    }

    public function getNoteCommentaire(): ?int
    {
        return $this->noteCommentaire;
    }

    public function setNoteCommentaire(?int $noteCommentaire): static
    {
        $this->noteCommentaire = $noteCommentaire;

        return $this;
    }

    public function getUnProduit(): ?Produit
    {
        return $this->unProduit;
    }

    public function setUnProduit(?Produit $unProduit): static
    {
        $this->unProduit = $unProduit;

        return $this;
    }

    public function getUnClient(): ?Client
    {
        return $this->unClient;
    }

    public function setUnClient(?Client $unClient): static
    {
        $this->unClient = $unClient;

        return $this;
    }

}
