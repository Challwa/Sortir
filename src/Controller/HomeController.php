<?php

namespace App\Controller;

use App\Entity\Participant;
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
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends AbstractController
{
    #[Route(path: "")]
    #[Route('/home', name: 'app_home', methods: ['GET', 'POST'])]
    public function home(Request $request, EntityManagerInterface $entityManager, SortieRepository $sortieRepository): Response
    {
        //gestion du formulaire de recherche par nom (filtre)
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        //Récupérer les sorties avec les états
        $sortiesToDisplay = $sortieRepository->findAllWithEtat();
        $sorties = $sortiesToDisplay;

        //on récupère l'utilisateur connecté pour les filtres checkbox
        $userConnected = $this->getUser();

        //filtre de recherche site, nom et date
        if ($form->isSubmitted()) {

            //on récupère les données écrites dans le formulaire
            $searchData = $form->getData();


            // on appelle la fonction filter du repository et on lui passe les données
            $sorties = $entityManager->getRepository(Sortie::class)->filter($searchData, $userConnected);
        }

        //Chercher les sites et les afficher dans un select en majuscule
        $sites = $entityManager->getRepository(Site::class)->findAll();
        foreach ($sites as $site) {
            $site->setNom(strtoupper($site->getNom()));
        }

        return $this->render('home/index.html.twig', [
            'sorties' => $sorties,
            'form' => $form
        ]);
    }
}
