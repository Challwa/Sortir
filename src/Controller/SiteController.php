<?php

namespace App\Controller;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'sites/', name: 'app_')]
class SiteController extends AbstractController
{
    #[Route(path: '', name: 'sites')]
    public function sites(EntityManagerInterface $entityManager): Response
    {
        $sites = $entityManager->getRepository(Site::class)->findAll();

        return $this->render('home/sites.html.twig', compact('sites'));
    }
}