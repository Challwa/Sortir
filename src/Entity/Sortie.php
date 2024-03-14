<?php

namespace App\Entity;

use App\Repository\SortieRepository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idSortie = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Le nom de la sortie est obligatoire')]
    #[Assert\Length(max:255, maxMessage: 'Le nom de la sortie ne doit pas dépasser 255 caractères')]
    private ?string $nom = null;

    #[ORM\Column(name :'date_heure_debut',type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: 'La date de la sortie est obligatoire')]
    private ? \DateTimeInterface $dateHeureDebut = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'La duree de la sortie est obligatoire')]
    #[Assert\Positive(message: 'La duree de la sortie doit être positive')]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: 'La date de la sortie est obligatoire')]
    private ? \DateTimeInterface $dateLimiteInscription = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: 'Le nombre maximum d\'inscrits est obligatoire')]
    #[Assert\Positive(message: 'Le nombre maximum d\'inscrits doit être positif')]
    private ?int $nbInscriptionsMax = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Le lieu de la sortie ne doit pas dépasser 255 caractères')]
    #[Assert\NotBlank(message: 'Le lieu de la sortie est obligatoire')]
    private ?string $infosSortie = null;

    #[ORM\Column(name: 'etat',type: Types::STRING, nullable: false)]
    private $etat;

    public function __construct()
    {
        $this->etat = 'ouverte';
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getDateHeureDebut()
    {
        return $this->dateHeureDebut;
    }

    /**
     * @param mixed $dateHeureDebut
     */
    public function setDateHeureDebut($dateHeureDebut): void
    {
        $this->dateHeureDebut = $dateHeureDebut;
    }

    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param mixed $duree
     */
    public function setDuree($duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @return mixed
     */
    public function getDateLimiteInscription()
    {
        return $this->dateLimiteInscription;
    }

    /**
     * @param mixed $dateLimiteInscription
     */
    public function setDateLimiteInscription($dateLimiteInscription): void
    {
        $this->dateLimiteInscription = $dateLimiteInscription;
    }

    /**
     * @return mixed
     */
    public function getNbInscriptionsMax()
    {
        return $this->nbInscriptionsMax;
    }

    /**
     * @param mixed $nbInscriptionsMax
     */
    public function setNbInscriptionsMax($nbInscriptionsMax): void
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;
    }

    /**
     * @return mixed
     */
    public function getInfosSortie()
    {
        return $this->infosSortie;
    }

    /**
     * @param mixed $infosSortie
     */
    public function setInfosSortie($infosSortie): void
    {
        $this->infosSortie = $infosSortie;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getIdSortie()
    {
        return $this->idSortie;
    }



}