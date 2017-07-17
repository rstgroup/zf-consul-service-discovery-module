<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Tests\ServiceDiscovery;


use PHPUnit\Framework\TestCase;
use RstGroup\ServiceDiscovery\ServiceDiscovery;
use RstGroup\ZfConsulServiceDiscoveryModule\ServiceDiscovery\ConsulController;
use Zend\Console\Request;
use Zend\Console\Response;


class ConsulControllerTest extends TestCase
{
    public function testItPassesNameAndIdOnRegisterAction()
    {
        // given: ServiceDiscovery mock
        $discoveryService = $this->getMockBuilder(ServiceDiscovery::class)->getMock();

        // given: controller
        $controller = new ConsulController('service', 'id', $discoveryService);

        // given: dispatch
        try {
            $controller->dispatch(new Request(), new Response());
        } catch (\Exception $exception) {}

        // expect
        $discoveryService->expects($this->once())->method('register')->with('service', ['id' => 'id']);

        // when
        $controller->registerAction();
    }

    public function testItPassesIdOnDeregisterAction()
    {
        // given: ServiceDiscovery mock
        $discoveryService = $this->getMockBuilder(ServiceDiscovery::class)->getMock();

        // given: controller
        $controller = new ConsulController('service', 'id', $discoveryService);

        // given: dispatch
        try {
            $controller->dispatch(new Request(), new Response());
        } catch (\Exception $exception) {}

        // expect
        $discoveryService->expects($this->once())->method('deregister')->with('id');

        // when
        $controller->deregisterAction();
    }
}
