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

        // config from application config
        $config = [
            'service_name' => 'service',
            'service_id' => 'id',
        ];

        // given: controller
        $controller = new ConsulController($config, $discoveryService);

        // given: dispatch
        try {
            $controller->dispatch(new Request(), new Response());
        } catch (\Exception $exception) {}

        // expect
        $discoveryService->expects($this->once())->method('register')->with('service', ['id' => 'id']);

        // when
        $controller->registerAction();
    }

    public function testItFetchesParametersFromCLI()
    {
        // given: ServiceDiscovery mock
        $discoveryService = $this->getMockBuilder(ServiceDiscovery::class)->getMock();

        // given: controller
        $controller = new ConsulController([], $discoveryService);

        // given: dispatch
        try {
            $controller->dispatch(new Request([
                'public/index.php',
                'id' => 'id',
                'name' => 'service',
                'check' => true,
                'check-url' => 'http://check/',
                'check-interval' => '10m',
                'check-name' => 'check',
                'tags' => ['tag']
            ]), new Response());
        } catch (\Exception $exception) {}

        // expect
        $discoveryService->expects($this->once())
            ->method('register')
            ->with('service', [
                'id' => 'id',
                'check' => [
                    'url' => 'http://check/',
                    'name' => 'check',
                    'interval' => '10m'
                ],
                'tags' => ['tag']
            ]);

        // when
        $controller->registerAction();
    }

    public function testItPassesIdOnDeregisterAction()
    {
        // given: ServiceDiscovery mock
        $discoveryService = $this->getMockBuilder(ServiceDiscovery::class)->getMock();

        // config from application config
        $config = [
            'service_name' => 'service',
            'service_id' => 'id',
        ];

        // given: controller
        $controller = new ConsulController($config, $discoveryService);

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
