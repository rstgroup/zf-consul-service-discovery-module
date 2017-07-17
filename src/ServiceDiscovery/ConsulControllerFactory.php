<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\ServiceDiscovery;


use Psr\Container\ContainerInterface;
use RstGroup\ServiceDiscovery\ServiceDiscovery;

/** @codeCoverageIgnore */
final class ConsulControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['rst_group']['service_discovery'];

        $serviceName = $config['service_name'];

        return new ConsulController(
            $serviceName,
            $container->get(ServiceDiscovery::class)
        );
    }
}
