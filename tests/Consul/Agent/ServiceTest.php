<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Tests\Consul\Agent;


use RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent\Check\HttpCheck;
use RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent\Service;


class ServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceIsMappedToApiDefinition()
    {
        // given: service
        $service = new Service('service-name');

        // when
        $apiDefinition = $service->getDefinition();

        // then
        $this->assertEquals(
            ['Name' => 'service-name', 'Id' => 'service-name'],
            $apiDefinition
        );
    }

    public function testServiceWithDifferentIdIsMappedToApiDefinition()
    {
        // given: service
        $service = new Service('service-name', 'service-id');

        // when
        $apiDefinition = $service->getDefinition();

        // then
        $this->assertEquals(
            ['Name' => 'service-name', 'Id' => 'service-id'],
            $apiDefinition
        );
    }

    public function testServiceWithCheckIsMappedToApiDefinition()
    {
        // given: check
        $check = new HttpCheck('service-check', 'http://localhost/check', '15m');

        // given: service
        $service = new Service('service', null, $check);

        // when
        $definition = $service->getDefinition();

        // then
        $this->assertEquals(
            [
                'Name'  => 'service',
                'Id'    => 'service',
                'Check' => [
                    'Name'     => 'service-check',
                    'HTTP'     => 'http://localhost/check',
                    'Interval' => '15m',
                ],
            ],
            $definition
        );
    }
}
