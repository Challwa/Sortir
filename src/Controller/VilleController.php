<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
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
        $villes = $entityManager->getRepository(Ville::class)->findAll();

        return $this->render('villes/villes.html.twig', [
            'villes' => $villes,
        ]);
    }

    #[Route(path: 'ajouter', name: 'ajouter')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ville = new Ville();
        $formVille = $this->createForm(VilleType::class, $ville);
        $formVille->handleRequest($request);

        if($formVille->isSubmitted() && $formVille->isValid()){


            $entityManager->persist($ville);
            $entityManager->flush();

            $this->addFlash('success', 'La  ville a bien été enregistrée');
            return $this->redirectToRoute('app_villes_');
        }

        return $this->render('villes/edit.html.twig', [
            'formVille' => $formVille,
        ]);
    }

    #[Route(path: 'supprimer/{id}', name: 'supprimer')]
    public function deleteVille(EntityManagerInterface $entityManager, Ville $ville): Response
    {
        $entityManager->remove($ville);
        $entityManager->flush();
        $this->addFlash('success', 'La ville a bien été supprimée');
        return $this->redirectToRoute('app_villes_');
    }
    #[Route(path: 'edit/{id}', name: 'edit')]
    public function editVille(Request $request, EntityManagerInterface $entityManager, Ville $ville): Response
    {
        $formVille = $this->createForm(VilleType::class, $ville);

        $formVille->handleRequest($request);

        if($formVille->isSubmitted()){

            $entityManager->persist($ville);
            $entityManager->flush();

            $this->addFlash('success', 'La ville a bien été modifié');
            return $this->redirectToRoute('app_villes_');
        }
        return $this->render('villes/edit.html.twig', [
            'formVille' => $formVille,
        ]);
    }
}