<?php

namespace App\Controller;

use App\Entity\Participant;

use App\Form\ProfileType;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\ParticipantRepository;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
#[Route(path: 'profil/', name: 'app_', methods: ['GET'])]
class UserController extends AbstractController
{

//fonction afficher profil user par son id
    #[Route(path: '', name: 'profil', methods: ['GET'])]
    public function profil(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new Participant();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('test@test.com', 'Test'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $security->login($user, AppAuthenticator::class, 'main');
        }

        return $this->render('home/profil.html.twig', [
            'profilForm' => $form,
        ]);
    }

    #[Route('/{id}', name: 'profil_update', methods: ['GET', 'POST'])]
    public function updateUser(User $user, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if($form->get('picture_file')->getData() instanceof UploadedFile) {
                $pictureFile = $form->get('picture_file')->getData();
                $fileName = $slugger->slug($user->getLastName()) . '-' . uniqid() . '.' . $pictureFile->guessExtension();
                $pictureFile->move('uploads', $fileName);
                $user->setPicture($fileName);
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success text-center', 'Votre profil a bien été mis à jour');
            return $this->redirectToRoute('app_show_profile', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

}