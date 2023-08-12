<?php

namespace App\Response;

use App\Entity\DeviceExperimentValue;
use Doctrine\Common\Collections\Collection;

class DeviceExperimentValuesToResponse
{
    /**
     * @param $deviceExperimentValues Collection<int, DeviceExperimentValue>
     */
    public static function toArray(Collection $deviceExperimentValues): array
    {
        $response = [];

        foreach ($deviceExperimentValues as $deviceExperimentValue) {
            $experimentValue = $deviceExperimentValue->getExperimentValue();
            $response[$experimentValue->getExperiment()->getIdentifier()] = $experimentValue->getValue();
        }

        return $response;
    }
}
