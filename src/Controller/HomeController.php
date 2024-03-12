<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: "")]
    #[Route('/home', name: 'app_home', methods : ['GET'])]
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route(path: "villes", name: "app_villes", methods: ["GET"])]
    public function villes(): Response
    {
        return $this->render('home/villes.html.twig');
    }

    #[Route(path: "sites", name: "app_sites", methods: ["GET"])]
    public function sites(): Response
    {
        return $this->render('home/sites.html.twig');
    }

    #[Route(path: "profil", name: "app_profil", methods: ["GET"])]
    public function profil(): Response
    {
        return $this->render('home/profil.html.twig');
    }

    #[Route(path: "inscription", name: "app_inscription", methods: ["GET"])]
    public function inscription(): Response
    {
        return $this->render('home/inscription.html.twig');
    }


}
