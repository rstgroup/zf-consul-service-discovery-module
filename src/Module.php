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
            'service-discovery consul configure --consul --name|-n [--service-id]' => 'Configure parameters of Consul Agent and stores them in app\'s configuration.',
            ['--consul', 'Consul Agent\'s URL' ],
            ['--name|-n', 'name of your service; if not provided, name will be fetched from app\'s configuration' ],
            ['--service-id', '(optional) ID of your service; by default the name of service is used' ],
            'service-discovery consul register' => 'Register service in Consul Agent\'s Service Discovery.',
            'service-discovery consul deregister' => 'Deregister service in Consul Agent\' Service Discovery.',
        ];
    }
}
