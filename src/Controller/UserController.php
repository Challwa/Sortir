<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;



class UserController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request,UserPasswordHasherInterface $userPasswordHasher , EntityManagerInterface $entityManager,UserPasswordHasherInterface $participantPasswordHasher): Response
    {
        $participant = new Participant();
        $form = $this->createForm(UserType::class, $participant);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            // encode the plain password
//            $participant->setPassword(
//                $participantPasswordHasher->hashPassword(
//                    $participant,
//                    $form->get('plainPassword')->getData()
//                )
    //);
//
//            $entityManager->persist($participant);
//            $entityManager->flush();
//
//            $text = "Un nouveau participant vient d'arriver : " . $participant->getEmail() . ". Bienvenue à lui sur Sortir !";;
//
//
//            return $this->redirectToRoute('app_login');
//        }

        return $this->render('home/creationCompte.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}