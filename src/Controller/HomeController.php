<?php

namespace App\Controller;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: "")]
    #[Route('/home', name: 'app_home', methods : ['GET'])]
    public function home(EntityManagerInterface $entityManager): Response
    {
        $sites = $entityManager->getRepository(Site::class)->findAll();
        return $this->render('home/index.html.twig', compact('sites'));
    }

    #[Route(path: "villes", name: "app_villes", methods: ["GET"])]
    public function villes(): Response
    {
        return $this->render('home/villes.html.twig');
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
