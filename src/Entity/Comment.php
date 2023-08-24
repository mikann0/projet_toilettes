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

    #[ORM\Column(type: Types::SMALLINT, nullable: true, name: "en_panne")]
    private ?int $enPanne;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, name: "n_existe__plus")]
    private ?int $nExistePlus;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, name: "acces_handicape")]
    private ?int $accesHandicape;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $commentaire;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: "date_commentaire")]
    private ?\DateTimeInterface $dateCommentaire;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false, name: "id_utilisateur_id")]
    private ?Utilisateur $idUtilisateur;

    #[ORM\Column(length: 20, name: "id_toilette")]
    private ?string $idToilette;

    public function __construct()
    {
       $this->dateCommentaire = new \DateTime();
    }

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

    public function getEnPanne(): ?int
    {
        return $this->enPanne;
    }

    public function setEnPanne(?int $en_panne)
    {
        $this->enPanne = $en_panne;
    }

    public function getNExistePlus(): ?int
    {
        return $this->nExistePlus;
    }

    public function setNExistePlus(?int $n_existe__plus)
    {
        $this->nExistePlus = $n_existe__plus;
    }

    public function getAccesHandicape(): ?int
    {
        return $this->accesHandicape;
    }

    public function setAccesHandicape(?int $acces_handicape)
    {
        $this->accesHandicape = $acces_handicape;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire)
    {
        $this->commentaire = $commentaire;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->dateCommentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $dateCommentaire)
    {
        $this->dateCommentaire = $dateCommentaire;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $id_utilisateur)
    {
        $this->idUtilisateur = $id_utilisateur;
    }

    public function getidToilette(): ?string
    {
        return $this->idToilette;
    }

    public function setIdToilette(string $id_toilette)
    {
        $this->idToilette = $id_toilette;
    }
}
