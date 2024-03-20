<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/participant', name: 'participant_')]
class ParticipantController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager, ParticipantRepository $repository)
    {

        $this->repository = $repository;
        $this->manager = $manager;

    }
    #[Route(path: '/detail/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(Participant $participant ): Response
    {


        return $this->render('participant/detail.html.twig', [
            'participant' => $participant,


        ]);


    }
}