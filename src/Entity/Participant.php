<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Participant implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id_participant', type: Types::INTEGER, nullable: false, options: ['unsigned' => true])]
    private int $idParticipant;

    #[ORM\Column(name : 'pseudo', type: Types::STRING ,length: 30, nullable: false)]
    private ?string $pseudo;

    #[ORM\Column(name : 'nom', type: Types::STRING ,length: 30, nullable: false)]
    private ?string $nom;

    #[ORM\Column(name : 'prenom', type: Types::STRING ,length: 30, nullable: false)]
    private ?string $prenom;

    #[ORM\Column(name : 'telephone', type: Types::STRING ,length: 15, nullable: true)]
    private ?string $telephone;

    #[ORM\Column(name : 'email', type: Types::STRING, length: 20, nullable: false)]
    private ?string $email;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(name : 'mot_de_passe', type: Types::STRING, nullable: false)]
    private ?string $password;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(name: 'roles')]
    private array $roles = [];

    #[ORM\Column(name : 'actif', type: Types::BOOLEAN, nullable: false)]
    private ?bool $actif;

    public function getId(): ?int
    {
        return $this->idParticipant;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getIdParticipant(): int
    {
        return $this->idParticipant;
    }

    public function setIdParticipant(int $idParticipant): void
    {
        $this->idParticipant = $idParticipant;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): void
    {
        $this->actif = $actif;
    }



    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
