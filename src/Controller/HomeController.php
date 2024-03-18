<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\SearchType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: "")]
    #[Route('/home', name: 'app_home')]
    public function home(Request $request, EntityManagerInterface $entityManager, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
    {

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $searchData = $form->getData();

            // Requête pour récupérer les sorties filtrées en fonction de la recherche
            $sorties =  $entityManager->getRepository(Sortie::class)->filter($searchData);

            $entityManager->persist();
            $entityManager->flush();

        }

        //Chercher les sites te les afficher dans un select en majuscule
        $sites = $entityManager->getRepository(Site::class)->findAll();
        foreach ($sites as $site){
            $site->setNom(strtoupper($site->getNom()));
        }

        //Afficher les états des sorties
        $sorties = $sortieRepository->findAllWithEtat();

        //Afficher les organisteurs selon les sorties
        $organisateur = $participantRepository->findAllWithOrganisateur();

        return $this->render('home/index.html.twig', compact('sites', 'sorties', 'organisateur', 'form'));
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
