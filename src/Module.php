<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule;


use Zend\ModuleManager\Feature\ConfigProviderInterface;

final class Module implements ConfigProviderInterface
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
}
