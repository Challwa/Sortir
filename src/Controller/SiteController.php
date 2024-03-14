<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route(path: 'ajouter', name: 'ajouter')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $site= new Site();
        $formSite = $this->createForm(SiteType::class, $site);

        $formSite->handleRequest($request);

        if($formSite->isSubmitted()){

            $entityManager->persist($site);
            $entityManager->flush();

            $this->addFlash('success', 'Le site a bien été enregistré');
            return $this->redirectToRoute('app_sites_');
        }

        return $this->render('sites/edit.html.twig', compact('formSite'));
    }


}