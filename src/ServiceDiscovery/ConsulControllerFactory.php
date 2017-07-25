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

        return new ConsulController(
            $config,
            $container->get(ServiceDiscovery::class)
        );
    }
}
