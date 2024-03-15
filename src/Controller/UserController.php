<?php

namespace App\Controller;

use App\Entity\Participant;

use App\Form\ProfileType;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function updateUser(Participant      $user, UserPasswordHasherInterface $userPasswordHasher,
                               Request          $request, EntityManagerInterface $entityManager,
                               SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $form->get('btnUpdate')->isClicked()) {

            /*check les données du form relatives à l'image sont une instance de UpdloadedFile
             ==> que qqc a bien été téléchargé dans le champ form de image*/
            if ($form->get('image')->getData() instanceof UploadedFile) {

                //récupère l'objet UpdloadedFile et stock dans $pictureFile
                $pictureFile = $form->get('image')->getData();

                //pour le nom de l'image (uniqid génère un id unique pour l'image)
                $fileName = $slugger->slug($user->getNom()) . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                //fichier téléchargé déplacé dans le dossier updloads
                $pictureFile->move($this->getParameter('picture_dir'), $fileName);

                //définir le nom du fichier dans image de user
                $user->setImage($fileName);

            }
            //pour modifier le mdp
            $user->setPassword(
            //service symfony permettant de hasher le mdp
                $userPasswordHasher->hashPassword(
                    $user,
                    //récupère le mdp en clair depuis le form
                    $form->get('plainPassword')->getData()));

            $entityManager->persist($user);
            $entityManager->flush();

            //message flash indiquand que tout s'est bien déroulé
            $this->addFlash('success text-center', 'Votre profil a bien été mis à jour');
            return $this->redirectToRoute('app_home', ['id' => $user->getId()]);
        }
        //renvoie vers le twig concernant le formulaire
        return $this->render('home/profil.html.twig', [
            //each éléments du tableau représentent une variable dispo dans le twig
            'profilForm' => $form,

            //données du user utilisables dans le twig form pour afficher ses informations
            'user' => $user
        ]);
    }

}