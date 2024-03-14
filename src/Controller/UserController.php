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




//    #[Route('update/{id}
//    ', name: 'update', methods: ['GET', 'POST'])]
//    // #[IsGranted('ROLE_USER')]
//    public function updateUser(Security $security, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
//    {
//        $user = $security->getUser() instanceof Participant ? $security->getUser() : $entityManager->getRepository(Participant::class)->find($security->getUser());
//
//        $form = $this->createForm(RegistrationFormType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $formData = $form->getData();
//            if (!empty($formData->getPseudo())) {
//                $user->setPseudo($formData->getPseudo());
//            }
//            if (!empty($formData->getPrenom())) {
//                $user->setPrenom($formData->getPrenom());
//            }
//            if (!empty($formData->getNom())) {
//                $user->setNom($formData->getNom());
//            }
//            if (!empty($formData->getTelephone())) {
//                $user->setTelephone($formData->getTelephone());
//            }
//
//            if (!empty($formData->getEmail())) {
//                $user->setEmail($formData->getEmail());
//            }
////            if ($form->get('picture')->getData() instanceof UploadedFile) {
////                $pictureFile = $form->get('picture')->getData();
////                $fileName = $slugger->slug($user->getUsername()) . '-' . uniqid() . '.' . $pictureFile->guessExtension();
////                $pictureFile->move($this->getParameter('picture_dir'), $fileName);
////                if (!empty($user->getPicture())) {
////                    $picturePath = $this->getParameter('picture_dir') . '/' . $user->getPicture();
////                    if (file_exists($picturePath)) {
////                        unlink($picturePath);
////                    }
////                }
////                $user->setPicture($fileName);
////            }
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//            $this->addFlash('success', 'Le profil a été mis à jour avec succès !');
//            return $this->redirectToRoute('user/index');
//        }
//
//        return $this->render('participant/updateUser.html.twig', [
//            'user' => $user,
//            'form' => $form->createView(),
//        ]);
//    }
}