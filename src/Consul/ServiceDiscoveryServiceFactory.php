<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Consul;


use Psr\Container\ContainerInterface;
use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\AgentInterface;

/** @codeCoverageIgnore */
final class ServiceDiscoveryServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $baseUri = $container->get('config')['rst_group']['service_discovery']['consul']['url'];

        // create agent service
        $agent = (new ServiceFactory(['base_uri' => $baseUri]))->get(AgentInterface::class);

        // return service discovery service
        return new ServiceDiscoveryService($agent);
    }
}
