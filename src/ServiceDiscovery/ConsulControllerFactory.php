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
        $serviceId = isset($config['service_id']) ? $config['service_id'] : $serviceName;

        return new ConsulController(
            $serviceName,
            $serviceId,
            $container->get(ServiceDiscovery::class)
        );
    }
}
