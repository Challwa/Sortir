<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'Etats')]
class Etat
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false, options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(name: 'libelle', type: Types::STRING, length: 30, nullable: false)]
    private string $libelle;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }


}