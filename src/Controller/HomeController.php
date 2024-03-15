<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: "")]
    #[Route('/home', name: 'app_home', methods : ['GET'])]
    public function home(EntityManagerInterface $entityManager, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
    {
        $sites = $entityManager->getRepository(Site::class)->findAll();
        $sorties = $sortieRepository->findAllWithEtat();
        $organisateur = $participantRepository->findAllWithOrganisateur();
        return $this->render('home/index.html.twig', compact('sites', 'sorties', 'organisateur'));
    }

   #[Route(path: "profil", name: "app_profil", methods: ["GET"])]
    public function profil(): Response
    {
        return $this->render('home/profil.html.twig');
    }

    #[Route(path: "creationCompte", name: "app_creationCompte", methods: ["GET"])]
    public function creationCompte(): Response
    {
        return $this->render('home/creationCompte.html.twig');
    }


}
