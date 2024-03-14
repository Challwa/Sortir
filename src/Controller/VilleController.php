<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'villes/', name: 'app_villes_')]
class VilleController extends AbstractController
{
    #[Route(path: '', name: '')]
    public function ville(EntityManagerInterface $entityManager): Response
    {
        $ville = $entityManager->getRepository(Ville::class)->findAll();

        return $this->render('villes/villes.html.twig', compact('ville'));
    }

    #[Route(path: 'ajouter', name: 'ajouter')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ville= new Ville();
        $formVille = $this->createForm(VilleType::class, $ville);

        $formVille->handleRequest($request);

        if($formVille->isSubmitted()){

            $entityManager->persist($ville);
            $entityManager->flush();

            $this->addFlash('success', 'La  ville a bien été enregistrée');
            return $this->redirectToRoute('app_villes_');
        }

        return $this->render('villes/edit.html.twig', compact('formVille'));
    }


}