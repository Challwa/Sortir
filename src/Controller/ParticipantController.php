<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ParticipantController extends AbstractController
{
    #[Route('/participant', name: 'app_participant')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Sender $sender, $participantPasswordHasher): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $participant->setPassword(
                $participantPasswordHasher->hashPassword(
                    $participant,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($participant);
            $entityManager->flush();

            $text = "Un nouveau participant vient d'arriver : " . $participant->getEmail() . ". Bienvenue à lui sur Sortir !";;

            $sender->sendEmail('Nouvelle inscription sur Sortir', $text, '');
            $sender->sendEmail('Bienvenue sur Sortir', 'Régale-toi mon copain, yolo !', $participant->getEmail());

            return $this->redirectToRoute('app_login');
        }

        return $this->render('participant/participant.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}