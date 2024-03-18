<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\EventDispatcher\Event;

#[Route(path: '/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{

    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    #[Route(path: '/detail/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(Sortie $sortie): Response
    {
        $participant=$sortie->getParticipants();
        return $this->render('sortie/detail.html.twig', [
            'sortie' => $sortie,
            'participant' => $participant

        ]);
    }

    #[Route(path: '/creer', name: 'creer')]
    public function creerSortie(Request $request, EntityManagerInterface $entityManager): Response
    {

        $sortie = new Sortie();

        $user = $this->getUser();

        $sortie->setOrganisateur($user);

        $formSortie = $this->createForm(SortieType::class, $sortie);

        $formSortie->handleRequest($request);

        if ($formSortie->isSubmitted() && $formSortie->isValid()) {

            if ($formSortie->get('btnRegister')->isClicked()) {

                $etat = $entityManager->getRepository(Etat::class)->find(1);

            } elseif ($formSortie->get('btnPublish')->isClicked()) {

                $etat = $entityManager->getRepository(Etat::class)->find(2);
            }
            $sortie->setEtats($etat);


            $sites = $user->getSites();
            $sortie->setSites($sites);


            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'La sortie a bien été crée.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('sortie/creerSortie.html.twig', [
            'formSortie' => $formSortie
        ]);
    }

    #[Route(path: '/modifier/{id}', name: 'modifier', requirements: ['id' => '\d+'])]
    public function modifierSortie(int $id, Sortie $sortie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $detailSortie = $entityManager->getRepository(Sortie::class)->find($id);

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('succes', 'La sortie a bien été modifiée');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('sortie/modifier.html.twig', [
            'modif_form' => $form, 'detailSortie' => $detailSortie,
        ]);

    }


}