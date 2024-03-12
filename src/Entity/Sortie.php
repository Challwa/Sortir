<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $idSortie;

    #[ORM\Column(name:'nom',type: Types::INTEGER, nullable: false, options: ['unsigned' => true], length: 30)]
    private $nom;

    #[ORM\Column(name: 'dateHeureDebut',type: Types::DATETIME_MUTABLE, nullable: false)]
    private $dateHeureDebut;

    #[ORM\Column(name: 'duree',type: Types::DATETIME_MUTABLE, nullable: false)]
    private $duree;

    #[ORM\Column(name: 'dateLimiteInscription',type: Types::DATETIME_MUTABLE, nullable: false)]
    private $dateLimiteInscription;

    #[ORM\Column(name: 'nbInscriptionsMax',type: Types::INTEGER, nullable: false)]
    private $nbInscriptionsMax;

    #[ORM\Column(name: 'infosSortie',type: Types::TEXT, nullable: false)]
    private $infosSortie;

    #[ORM\Column(name: 'etat',type: Types::STRING, nullable: false)]
    private $etat;

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