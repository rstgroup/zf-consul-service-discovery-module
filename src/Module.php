<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule;


use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

final class Module implements ConfigProviderInterface, ConsoleUsageProviderInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public function getConsoleUsage(AdapterInterface $console)
    {
        return [
            'ZF Service Discovery - Consul',
            'service-discovery consul register' => 'Register service in Consul Agent\'s Service Discovery.',
            'service-discovery consul deregister' => 'Deregister service in Consul Agent\' Service Discovery.',
        ];
    }
}
