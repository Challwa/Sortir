<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }


    #[Route(path: '/creer', name: 'creer')]
    public function creerSortie(Request $request, EntityManagerInterface $entityManager): Response
{

    $sortie = new Sortie();

    $user = $this->getUser();

    $sortie->setOrganisateur($user);

    $formSortie = $this->createForm(SortieType::class, $sortie);

    $formSortie->handleRequest($request);

    if ($formSortie->isSubmitted() && $formSortie->isValid()) {

        if ($formSortie->get('btnRegister')->isClicked()) {

            $etat = $entityManager->getRepository(Etat::class)->find(1);

        } elseif ($formSortie->get('btnPublish')->isClicked()) {

            $etat = $entityManager->getRepository(Etat::class)->find(2);
        }

        $sortie->setEtats($etat);

        $sites = $entityManager->getRepository(Site::class)->find(1);
        $sortie->setSites($sites);


        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('success', 'La sortie a bien été crée.');

        return $this->redirectToRoute('app_home'); // a changer apres la creation de la vue des sorties -> sorties.html.twig
    }

        return $this->render('sortie/creerSortie.html.twig', [
            'formSortie' => $formSortie
        ]);

}
}