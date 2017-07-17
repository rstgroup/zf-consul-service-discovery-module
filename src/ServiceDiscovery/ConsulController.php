<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\ServiceDiscovery;


use RstGroup\ServiceDiscovery\ServiceDiscovery;
use Zend\Console\Request;
use Zend\Mvc\Console\Controller\AbstractConsoleController;

final class ConsulController extends AbstractConsoleController
{
    /** @var  string */
    private $serviceName;

    /** @var  string */
    private $serviceId;

    /** @var ServiceDiscovery */
    private $serviceDiscoveryService;

    /**
     * @param string           $serviceName
     * @param string           $serviceId
     * @param ServiceDiscovery $serviceDiscoveryService
     */
    public function __construct($serviceName, $serviceId, ServiceDiscovery $serviceDiscoveryService)
    {
        $this->serviceName             = $serviceName;
        $this->serviceId               = $serviceId;
        $this->serviceDiscoveryService = $serviceDiscoveryService;
    }

    public function registerAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request instanceof Request) {
            throw new \RuntimeException("Consul Service Discovery controller is available only from CLI.");
        }

        $this->serviceDiscoveryService->register($this->serviceName, [
            'id' => $this->serviceId,
        ]);
    }

    public function deregisterAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request instanceof Request) {
            throw new \RuntimeException("Consul Service Discovery controller is available only from CLI.");
        }

        $this->serviceDiscoveryService->deregister($this->serviceId, []);
    }
}
