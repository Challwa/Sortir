<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'villes/', name: 'app_')]
class VilleController extends AbstractController
{
    #[Route(path: '', name: 'villes')]
    public function villes(EntityManagerInterface $entityManager): Response
    {
        $villes = $entityManager->getRepository(Ville::class)->findAll();

        return $this->render('home/villes.html.twig', compact('villes'));
    }

    #[Route(path: 'edit/{id}', name: 'edit')]
    public function edit(Ville $ville): Response
    {
        return $this->render('ville/edit.html.twig', compact('ville'));
    }

    #[Route(path: 'delete/{id}', name: 'delete')]
    public function delete(Ville $ville): Response
    {
        return $this->render('ville/delete.html.twig', compact('ville'));
    }
}
