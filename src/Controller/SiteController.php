<?php

namespace App\Controller;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'sites/', name: 'app_sites_')]
class SiteController extends AbstractController
{
    #[Route(path: '', name: '')]
    public function sites(EntityManagerInterface $entityManager): Response
    {
        $sites = $entityManager->getRepository(Site::class)->findAll();

        return $this->render('sites/sites.html.twig', compact('sites'));
    }

    #[Route(path: '{id}', name: 'edit')]
    public function edit(int $id, EntityManagerInterface $entityManager): Response
    {
        $detail = $entityManager->getRepository(Site::class)->findOneBy([
            'id' => $id
        ]);

        return $this->render('sites/edit.html.twig', compact('detail'));
    }


}