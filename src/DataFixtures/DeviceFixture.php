<?php

namespace App\DataFixtures;

use App\Entity\Device;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DeviceFixture extends Fixture
{
    public const DEVICE_WITHOUT_EXPERIMENTS = '051f966d-dd10-49ed-be40-2d4f6f636064';

    public function load(ObjectManager $manager): void
    {
        $device = new Device();
        $device->setToken(self::DEVICE_WITHOUT_EXPERIMENTS);

        $manager->persist($device);
        $manager->flush();
    }
}
