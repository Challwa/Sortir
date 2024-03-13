<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route(path: '/creer', name: 'creer', methods: ["GET", "POST"])]
    public function creerSortie(Request $request, EntityManagerInterface $entityManager): Response
{

    $sortie = new Sortie();

    $formSortie = $this->createForm(SortieType::class, $sortie);

    $formSortie->handleRequest($request);

    if ($formSortie->isSubmitted() && $formSortie->isValid()) {

        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('success', 'La sortie a bien été crée.');

        return $this->redirectToRoute('app_home'); // a changer apres la creation de la vue des sorties -> sorties.html.twig
    }

        return $this->render('sortie/creerSortie.html.twig', [
            'formSortie' => $formSortie->createView(),
        ]);

}
}