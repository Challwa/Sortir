<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\ProfileType;
use App\Form\SortieType;
use App\Repository\LieuRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route(path: '/detail', name: 'detail')]
    public function detail(SortieRepository $sortieRepository, LieuRepository $lieuRepository): Response
    {
        $sorties = $sortieRepository->findSortiebyId();
        $lieu = $lieuRepository->findAll();

        return $this->render('sortie/detail.html.twig', compact('sorties', 'lieu'));


    }

    private $authenticationUtils;


    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
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

    #[Route(path: "/{id}", name: "modifier")]
    public function modifier(int $id, EntityManagerInterface $entityManager): Response
    {
        $detail = $entityManager->getRepository(Sortie::class)->findOneBy([
           'id' => $id
        ]);

        return $this->render('sortie/modifier.html.twig', compact('detail'));
    }
}