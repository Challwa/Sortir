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
            $dateDebut = $sortie->getDateHeureDebut();

            //gestion état "activité passée"
            if ($dateFinSortie < new \DateTime()) {
                $etat = $this->entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'activite passee']);
                $sortie->setEtats($etat);
            }
            $now = new \DateTime('now');


            //gestion etat "ouverte"

            if ($dateDebut && $dateFinSortie > $now) {

            }

            //gestion état "archivée"
            if ($sortie->getEtats()->getId() === 5 || $sortie->getEtats()->getId() === 6 || $sortie->getEtats()->getId() === 3) {
                if ($sortie->getDateHeureDebut()->modify('+1 month') < $now) {
                    $sortie->setEtats($etat = $this->entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'archivee']));
                }
            }

            //gestion état "clôturée"
            if ($sortie->getEtats()->getId() !== 5) {
                if ($sortie->getParticipants()->count() === $sortie->getNbInscriptionsMax()) {

                    $difference = $now->diff($dateDebut);
                    $interval = $difference->format('%m');

                    if ($interval < 1) {
                        $etat = $this->entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'cloturee']);
                        $sortie->setEtats($etat);
                    }
                }
            }
            //gestion état "activité en cours"
            if($dateDebut < $now && $now< ($dateDebut + $sortie->getDuree())) {
                $etat = $this->entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'activite en cours']);
                $sortie->setEtats($etat);
            }
        }

        $this->entityManager->flush();
    }

}