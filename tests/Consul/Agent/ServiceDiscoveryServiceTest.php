<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Tests\Consul\Agent;


use RstGroup\ZfConsulServiceDiscoveryModule\Consul\ServiceDiscoveryService;
use PHPUnit\Framework\TestCase;
use SensioLabs\Consul\Services\AgentInterface;

class ServiceDiscoveryServiceTest extends TestCase
{
    public function testItPassesServiceDefinitionToConsulAgentOnRegister()
    {
        // given: mocked agent
        $agent = $this->getMockBuilder(AgentInterface::class)->getMock();

        // given:
        $serviceDiscovery = new ServiceDiscoveryService(
            $agent
        );

        // expect: values passed to agent
        $agent->expects($this->once())->method('registerService')->with([
            'Name'  => 'service',
            'Id'    => 'service-id',
            'Tags'  => ['tag-1', 'tag-2'],
            'Check' => [
                'Name'     => 'check',
                'HTTP'     => 'http://check/',
                'Interval' => '10m',
            ],
        ]);

        // when: register called
        $serviceDiscovery->register('service', [
            'id'    => 'service-id',
            'tags'  => ['tag-1', 'tag-2'],
            'check' => [
                'url'      => 'http://check/',
                'name'     => 'check',
                'interval' => '10m',
            ],
        ]);
    }

    public function testItPassesServiceIdToConsulAgentOnDeregister()
    {
        // given: mocked agent
        $agent = $this->getMockBuilder(AgentInterface::class)->getMock();

        // given:
        $serviceDiscovery = new ServiceDiscoveryService(
            $agent
        );

        // expect: values passed to agent
        $agent->expects($this->once())->method('deregisterService')->with('service-id');

        // when: register called
        $serviceDiscovery->deregister('service-id');
    }
}
