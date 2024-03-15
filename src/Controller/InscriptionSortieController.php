<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InscriptionSortieController extends AbstractController
{
    #[Route('/inscription/{id}', name: 'inscription_sortie')]
    public function inscription(EntityManagerInterface $entityManager, Participant $participant, $security, Request $request , int $id): Response
    {
        $user = $security->getUser();
        $sortie = $entityManager->getRepository(Sortie::class)->find($id);

        //état de la sortie?

        $etatSortie = $sortie->getEtats()->getId();

        if($etatSortie !== 2){
            $this->addFlash('danger', 'La sortie n\'est pas encore ouverte');
            return $this->redirectToRoute('app_home');
        }
       if ($sortie->getParticipants()->contains($user)) {
           $this->addFlash('danger', 'Vous participez déja a cette sortie');
           return $this->redirectToRoute('app_home');
       }
       if ($sortie->getDateLimiteInscription() < new \DateTime()) {
           $this->addFlash('danger', 'La date d\'inscription est dépassée');
           return $this->redirectToRoute('app_home');
       }
       if($sortie->getParticipants()->count() >= $sortie->getNbInscriptionsMax()){
           $this->addFlash('danger', 'La sortie est complete');
           return $this->redirectToRoute('app_home');
       }
        // Ajouter l'user
        $sortie->addParticipant($participant);

        // Enregistrer dans la base de données
        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->render('home/index.html.twig');
    }
}
