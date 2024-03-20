<?php

namespace App\Service;

use App\Entity\Etat;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;

class SortieService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function updateEtatSortie(): void
    {

        $sorties = $this->entityManager->getRepository(Sortie::class)->findAll();

        foreach ($sorties as $sortie) {
            $dateFinSortie = clone $sortie->getDateHeureDebut();
            $dateFinSortie->modify('+ ' . $sortie->getDuree() . ' minutes');

            if ($dateFinSortie < new \DateTime()) {
                $etat = $this->entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'activite passee']);
                $sortie->setEtats($etat);
            }
            $now = new \DateTime('now');

            if ($sortie->getEtats()->getId() === 5 || $sortie->getEtats()->getId() === 6 || $sortie->getEtats()->getId() === 3) {
                if ($sortie->getDateHeureDebut()->modify('+1 month') < $now) {
                    $sortie->setEtats($etat = $this->entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'archivee']));
                }
            }

            if ($sortie->getParticipants()->count() === $sortie->getNbInscriptionsMax()) {
                $dateDebut = $sortie->getDateHeureDebut();
                $difference = $now->diff($dateDebut);
                $interval = $difference->format('%m'); // Obtient le nombre de mois de la différence

                if ($interval < 1) {
                    $etat = $this->entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'cloturee']);
                    $sortie->setEtats($etat);
                }
            }
        }

        $this->entityManager->flush();
    }

}