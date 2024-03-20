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
    #[Route('/home', name: 'app_home', methods:['GET', 'POST'])]
    public function home(Request $request, EntityManagerInterface $entityManager, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
    {

        //gestion du formulaire de recherche par nom (filtre)
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        //Récupérer les états des sorties
        $sortiesToDisplay = $sortieRepository->findAllWithEtat();
        $sorties = $sortiesToDisplay;

        if ($form->isSubmitted()) {
            $searchData = $form->getData();

            // Requête pour récupérer les sorties filtrées en fonction de la recherche
            $sorties =  $entityManager->getRepository(Sortie::class)->filter($searchData);

        }

        //Chercher les sites te les afficher dans un select en majuscule
        $sites = $entityManager->getRepository(Site::class)->findAll();
        foreach ($sites as $site){
            $site->setNom(strtoupper($site->getNom()));
        }

        //Afficher les organisteurs selon les sorties
        $organisateur = $participantRepository->findAllWithOrganisateur();


        return $this->render('home/index.html.twig', [
            'sites' => $sites,
            'sorties' => $sorties,
            'organisateur' => $organisateur,
            'form' => $form
        ]);
    }

}
