<?php

namespace App\Tests\Feature\Controller;

use App\DataFixtures\DeviceFixture;
use JsonException;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExperimentControllerTest extends WebTestCase
{
    public function testListExperiment(): void
    {
        $client = static::createClient([], [
            'HTTP_Device-Token' => Uuid::uuid4(),
        ]);

        $json = $this->makeRequest($client);

        $this->assertArrayHasKey('button_color', $json);
        $this->assertArrayHasKey('price', $json);
        $this->assertContains($json['button_color'], ['#FF0000', '#00FF00', '#0000FF']);
        $this->assertContains(intval($json['price']), [10, 20, 50, 5]);

        $jsonRetry = $this->makeRequest($client);

        $this->assertEquals($json['button_color'], $jsonRetry['button_color']);
        $this->assertEquals($json['price'], $jsonRetry['price']);
    }

    public function testDeviceWithoutExperiments(): void
    {
        $client = static::createClient([], [
            'HTTP_Device-Token' => DeviceFixture::DEVICE_WITHOUT_EXPERIMENTS,
        ]);

        $json = $this->makeRequest($client);

        $this->assertEmpty($json);
    }

    /**
     * @throws JsonException
     */
    private function makeRequest(KernelBrowser $client): array
    {
        $client->request('GET', '/api/experiment');
        $this->assertResponseIsSuccessful();

        return json_decode($client->getResponse()->getContent(), true, flags: JSON_THROW_ON_ERROR);
    }
}
