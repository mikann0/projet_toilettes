<?php

namespace App\Entity;

use App\Entity\Comment;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Un compte avec cette adresse e-mail existe déjà.')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password;

    #[ORM\Column(length: 30)]
    private ?string $nom;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, name: "date_ins")]
    private ?\DateTimeInterface $dateIns;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, name : "last_login")]
    private ?\DateTimeInterface $lastLogin;

    #[ORM\OneToMany(mappedBy: 'id_utilisateur', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
       $this->dateIns = new \DateTimeImmutable();
        $this->addRole("ROLE_UTILISATEUR");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_UTILISATEUR
        $roles[] = 'ROLE_UTILISATEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

    }

    
    public function addRole(string $role)
    {
        $this->roles[]=$role;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    public function getDateIns(): ?\DateTimeInterface
    {
        return $this->dateIns;
    }

    public function setDateIns(\DateTimeInterface $date_ins)
    {
        $this->dateIns = $date_ins;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $last_login)
    {
        $this->lastLogin = $last_login;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment)
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setIdUtilisateur($this);
        }
    }

    public function removeComment(Comment $comment)
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getIdUtilisateur() === $this) {
                $comment->setIdUtilisateur(null);
            }
        }
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
