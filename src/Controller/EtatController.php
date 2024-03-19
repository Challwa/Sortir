<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\EtatType;
use App\Service\SortieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/etat')]
class EtatController extends AbstractController
{
  private $sortieService;

    public function getSortieService(): SortieService
    {
        return $this->sortieService;
    }

  public function __construct(SortieService $sortieService)
  {
      $this->sortieService = $sortieService;
  }

    #[Route('/update', name: 'update_etats')]
    public function updateEtatsOnLogin(EntityManagerInterface $entityManager,Sortie $sortie): Response
    {
        $user = $this->getUser();
        if ($user) {
            $this->sortieService->updateEtatSortie(); //appel de la fonction updateEtats -> SortieService.php
        }

        return $this->redirectToRoute('app_home');
    }
}
