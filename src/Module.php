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
            'service-discovery consul register [--id=] [--name=] [--tags=] [--check] [--check-url=] [--check-name=] [--check-interval=]' =>
                'Register service in Consul Agent\'s Service Discovery.',
            ['--id=', 'Override ID of service.'],
            ['--name=', 'Override name of service.'],
            ['--tags=', 'Override list of tags. Use multiple times.'],
            ['--check', 'If flag is set, the check is expected to be defined.'],
            ['--check-url', 'Override service\'s check URL'],
            ['--check-name', 'Override service\'s check name'],
            ['--check-interval', 'Override service\'s check interval'],
            'service-discovery consul deregister [--id=]' =>
                'Deregister service in Consul Agent\' Service Discovery.',
            ['--id=', 'Override ID of service.'],
        ];
    }
}
