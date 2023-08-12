<?php

namespace App\DataFixtures;

use App\Entity\Experiment;
use App\Entity\ExperimentValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExperimentFixture extends Fixture
{
    private const EXPERIMENTS = [
        [
            'identifier' => 'button_color',
            'values' => [
                [
                    'value' => '#FF0000',
                    'share' => 33,
                ],
                [
                    'value' => '#00FF00',
                    'share' => 33,
                ],
                [
                    'value' => '#0000FF',
                    'share' => 33,
                ],
            ],
        ],
        [
            'identifier' => 'price',
            'values' => [
                [
                    'value' => '10',
                    'share' => 75,
                ],
                [
                    'value' => '20',
                    'share' => 10,
                ],
                [
                    'value' => '50',
                    'share' => 5,
                ],
                [
                    'value' => '5',
                    'share' => 10,
                ],
            ],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::EXPERIMENTS as $experimentData) {
            $experiment = new Experiment();
            $experiment->setIdentifier($experimentData['identifier']);

            foreach ($experimentData['values'] as $valueContainer) {
                $experiment->addExperimentValue(
                    (new ExperimentValue())
                        ->setValue($valueContainer['value'])
                        ->setShare($valueContainer['share'])
                );
            }

            $manager->persist($experiment);
        }

        $manager->flush();
    }
}
