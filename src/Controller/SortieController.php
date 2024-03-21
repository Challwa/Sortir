<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\AnnulationType;
use App\Form\SortieType;
use App\Repository\LieuRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $participants = $sortie->getParticipants();
        return $this->render('sortie/detail.html.twig', [
            'sortie' => $sortie,
            'participants' => $participants

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

        if ($formSortie->isSubmitted() )  {

            if ($formSortie->get('btnRegister')->isClicked()) {

                $etat = $entityManager->getRepository(Etat::class)->find(1);

            } elseif ($formSortie->get('btnPublish')->isClicked()) {

                $etat = $entityManager->getRepository(Etat::class)->find(2);
            }
            $sortie->setEtats($etat);


            $sites = $user->getSites();
            $sortie->setSites($sites);


            $lieu = $formSortie->getData()->getLieux();

            $sortie->setLieux($lieu);
//          dd($lieu);


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

        if ($form->isSubmitted()) {
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('succes', 'La sortie a bien été modifiée');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('sortie/modifier.html.twig', [
            'modif_form' => $form, 'detailSortie' => $detailSortie,
        ]);
    }

    #[Route(path: '/annuler/{id}', name: 'annuler', requirements: ['id' => '\d+'])]
    public function annulerSortie(int $id, Sortie $sortie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $annulerSortie = $entityManager->getRepository(Sortie::class)->find($id);

        $form = $this->createForm(AnnulationType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->get('btnRegister')->isClicked()) {

                $etat = $entityManager->getRepository(Etat::class)->find(6);
            }
            $sortie->setEtats($etat);

            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('succes', 'L\'annulation a bien été modifiée');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('sortie/annulation.html.twig', [
            'annuler_form' => $form, 'annulerSortie' => $annulerSortie,
        ]);
    }

    #[Route(path:'/publier/{id}', name: 'publier')]
    public function publierSortie(int $id, Sortie $sortie, EntityManagerInterface $entityManager): RedirectResponse
    {
        $etatOuverte = $entityManager->getRepository(Etat::class)->find(2);
        $sortie->setEtats($etatOuverte);
        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('success', 'La sortie a bien été publiee');

        return $this->redirectToRoute('app_home');

    }
}