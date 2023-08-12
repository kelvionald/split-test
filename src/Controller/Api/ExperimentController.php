<?php

namespace App\Controller\Api;

use App\Enum\RequestHttpHeader;
use App\Response\DeviceExperimentValuesToResponse;
use App\Service\ExperimentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

class ExperimentController extends AbstractController
{
    #[Route('/api/experiment', name: 'api_experiment_list', methods: 'GET')]
    public function list(Request $request, ExperimentService $experimentService): Response
    {
        $deviceToken = $request->headers->get(RequestHttpHeader::DEVICE_TOKEN);
        $validator = Validation::createValidator();
        $violations = $validator->validate($deviceToken, [
            new Uuid(),
            new NotBlank(),
        ]);

        if (0 !== count($violations)) {
            return $this->json([
                'error' => array_map(
                    fn(ConstraintViolation $violation) => [
                        RequestHttpHeader::DEVICE_TOKEN => $violation->getMessage(),
                    ],
                    [...$violations]
                ),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $deviceExperimentValues = $experimentService->getList($deviceToken);

        return $this->json(DeviceExperimentValuesToResponse::toArray($deviceExperimentValues));
    }
}
