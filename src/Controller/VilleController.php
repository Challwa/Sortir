<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ville')]
class VilleController extends AbstractController
{


    #[Route('/ville', name: 'ville', methods: ['GET'])]
    /*
  * ne pas oublier le
  #[IsGranted('ROLE_USER')]
  * */
    public function ville(): Response
    {
        $villes = $this->getRepository(Ville::class)->findAll();
        return $this->render('ville/index.html.twig', [
            'villes' => $villes
        ]);
    }


}
