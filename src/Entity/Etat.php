<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'etats')]
    private Collection $sorties;

    public function __construct()
    {
        $this->sorties = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSortie(Sortie $sortie): void
    {
        if (!$this->sorties->contains($sortie)) {
            $this->sorties[] = $sortie;
            $sortie->setEtats($this);
        }

    }

    public function removeSortie(Sortie $sortie): void
    {
        $this->sorties->removeElement($sortie);

       if ($sortie->getEtats() === $this) {
           $sortie->setEtats(null);
       }
    }


}