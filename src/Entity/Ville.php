<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'Villes')]
class Ville
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false, options: ['unsigned' => true])]
    private int $id ;


    #[ORM\Column(name: 'nom', type: Types::STRING, length: 30, nullable: false)]
    private string $nom ;

    #[ORM\Column(name: 'codePostal', type: Types::STRING, length: 10, nullable: false)]
    private string $codePostal;

    public function getId(): int
    {
        return $this->id;
    }


    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): void
    {
        $this->codePostal = $codePostal;
    }




}