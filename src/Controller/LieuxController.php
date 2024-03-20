<?php

namespace App\Controller;

use App\Entity\Lieu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lieu')]
class LieuxController extends AbstractController
{
    #[Route('/info/{id}', name: 'lieu_info')]
    public function getInfoLieu(Lieu $lieu): JsonResponse
    {
        $information = [
            'ville' => $lieu->getVilles()-> getNom(),
            'rue' => $lieu->getRue(),
            'codepostal' => $lieu->getVilles()->getCodePostal(),
            'latitude' => $lieu->getLatitude(),
            'longitude' => $lieu->getLongitude(),
        ];
        return new JsonResponse($information);
    }
}
