<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InscriptionSortieController extends AbstractController
{
    #[Route('/inscription/{id}', name: 'inscription_sortie')]
    public function inscription(EntityManagerInterface $entityManager, int $id): Response
    {
        $userId = $this->getUser()->getId();

        // Recuperer la sortie
        $sortie = $entityManager->getRepository(Sortie::class)->find($id);

        // Recuperer le participant
        $participant = $entityManager->getRepository(Participant::class)->find($userId);

        if (!$sortie) {
            throw $this->createNotFoundException('La sortie demandée n\'existe pas.');
        }

        // Verifier l'etat de la sortie et tout les contraintes
        $etatSortie = $sortie->getEtats()->getId();

        if ($etatSortie !== 2) {
            $this->addFlash('danger', 'La sortie n\'est pas encore ouverte');
            return $this->redirectToRoute('app_home');
        }

        if ($sortie->getParticipants()->contains($participant)) {
            $this->addFlash('danger', 'Vous participez déjà à cette sortie');
            return $this->redirectToRoute('app_home');
        }

        if ($sortie->getDateLimiteInscription() < new \DateTime()) {
            $this->addFlash('danger', 'La date d\'inscription est dépassée');
            return $this->redirectToRoute('app_home');
        }

        if ($sortie->getParticipants()->count() >= $sortie->getNbInscriptionsMax()) {
            $this->addFlash('danger', 'La sortie est complète');
            return $this->redirectToRoute('app_home');
        }

        // Asocier le participant à la sortie
        $sortie->addParticipant($participant);

        // Persist vers la bdd
        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('success', 'Inscription réussie !');

        return $this->redirectToRoute('app_home');
    }
}