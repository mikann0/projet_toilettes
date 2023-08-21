<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $note;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $en_panne;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $n_existe__plus;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $acces_handicape;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $commentaire;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_commentaire;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $id_utilisateur;

    #[ORM\Column(length: 20)]
    private ?string $id_toilette;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note)
    {
        $this->note = $note;
    }

    public function geten_panne(): ?int
    {
        return $this->en_panne;
    }

    public function seten_panne(?int $en_panne)
    {
        $this->en_panne = $en_panne;
    }

    public function getn_existe__plus(): ?int
    {
        return $this->n_existe__plus;
    }

    public function setn_existe__plus(?int $n_existe__plus)
    {
        $this->n_existe__plus = $n_existe__plus;
    }

    public function getacces_handicape(): ?int
    {
        return $this->acces_handicape;
    }

    public function setacces_handicape(?int $acces_handicape)
    {
        $this->acces_handicape = $acces_handicape;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire)
    {
        $this->commentaire = $commentaire;
    }

    public function getdate_commentaire(): ?\DateTimeInterface
    {
        return $this->date_commentaire;
    }

    public function setdate_commentaire(\DateTimeInterface $date_commentaire)
    {
        $this->date_commentaire = $date_commentaire;
    }

    public function getid_utilisateur(): ?Utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setid_utilisateur(?Utilisateur $id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getid_toilette(): ?string
    {
        return $this->id_toilette;
    }

    public function setid_toilette(string $id_toilette)
    {
        $this->id_toilette = $id_toilette;
    }
}
