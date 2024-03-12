<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Form\EtatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/etat')]
class EtatController extends AbstractController
{
    #[Route('/etat', name: 'etat', methods: ['GET'])]
    public function etat(): Response
    {
        return $this->render('etat/index.html.twig', [
            'controller_name' => 'EtatController',
        ]);
    }

}
