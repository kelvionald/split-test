<?php

namespace App\Controller\Front;

use App\Service\ExperimentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperimentController extends AbstractController
{
    #[Route('/statistics', name: 'front_experiment_list', methods: 'GET')]
    public function list(ExperimentService $experimentService): Response
    {
        $experimentStatistics = $experimentService->getStatistics();

        return $this->render('pages/statistics.html.twig', [
            'experimentStatistics' => $experimentStatistics,
        ]);
    }
}
