<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\ServiceDiscovery;


use RstGroup\ServiceDiscovery\ServiceDiscovery;
use Webmozart\Assert\Assert;
use Zend\Console\Request;
use Zend\Mvc\Console\Controller\AbstractConsoleController;

final class ConsulController extends AbstractConsoleController
{
    /** @var ServiceDiscovery */
    private $serviceDiscoveryService;

    /** @var array */
    private $config;

    /**
     * @param array            $config
     * @param ServiceDiscovery $serviceDiscoveryService
     */
    public function __construct(array $config, ServiceDiscovery $serviceDiscoveryService)
    {
        $this->config                  = $config;
        $this->serviceDiscoveryService = $serviceDiscoveryService;
    }

    /**
     * @param string|string[] $key
     * @return mixed
     */
    private function getFromConfig($key)
    {
        $config = $this->config;

        foreach ((array)$key as $keyPart) {
            if (is_array($config) && array_key_exists($keyPart, $config)) {
                $config = &$config[$keyPart];
            } else {
                return null;
            }
        }

        return $config;
    }

    public function registerAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        // fetch some params.. from request of from config :)
        $serviceId   = $request->getParam('id', $this->getFromConfig('service_id'));
        $serviceName = $request->getParam('name', $this->getFromConfig('service_name'));
        $tags        = (array)$request->getParam('tags', $this->getFromConfig(['consul', 'tags']));
        $isCheck = $request->getParam('check', false);

        if ($isCheck) {
            Assert::notNull($request->getParam('check-name'));
            Assert::notNull($request->getParam('check-url'));
        }

        $check       = array_filter([
            'name'     => $request->getParam('check-name', $this->getFromConfig(['consul', 'check', 'name'])),
            'url'      => $request->getParam('check-url', $this->getFromConfig(['consul', 'check', 'url'])),
            'interval' => $request->getParam('check-interval', $this->getFromConfig(['consul', 'check', 'interval'])),
        ]);


        if (!$request instanceof Request) {
            throw new \RuntimeException("Consul Service Discovery controller is available only from CLI.");
        }

        $this->serviceDiscoveryService->register($serviceName, array_filter([
            'id'    => $serviceId,
            'check' => $check,
            'tags'  => $tags,
        ]));
    }

    public function deregisterAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request instanceof Request) {
            throw new \RuntimeException("Consul Service Discovery controller is available only from CLI.");
        }

        $serviceId = $request->getParam('id', $this->getFromConfig('service_id')) ?: $this->getFromConfig('service_name');


        $this->serviceDiscoveryService->deregister($serviceId, []);
    }
}
