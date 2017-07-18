<?php

return [
    'rst_group'       => [
        'service_discovery' => [
            'service_name' => '',
            'service_id'   => null,
            'consul'       => [
                'url' => 'http://127.0.0.1:8500',
            ],
        ],
    ],
    'controllers'     => [
        'factories' => [
            \RstGroup\ZfConsulServiceDiscoveryModule\ServiceDiscovery\ConsulController::class => \RstGroup\ZfConsulServiceDiscoveryModule\ServiceDiscovery\ConsulControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'aliases'   => [
            \RstGroup\ServiceDiscovery\ServiceDiscovery::class => \RstGroup\ZfConsulServiceDiscoveryModule\Consul\ServiceDiscoveryService::class,
        ],
        'factories' => [
            \RstGroup\ZfConsulServiceDiscoveryModule\Consul\ServiceDiscoveryService::class => \RstGroup\ZfConsulServiceDiscoveryModule\Consul\ServiceDiscoveryServiceFactory::class,
        ],
    ],
    'console'         => [
        'router' => [
            'routes' => [
                'consul-sd-register'   => [
                    'options' => [
                        'route'    => 'service-discovery consul register',
                        'defaults' => [
                            'controller' => \RstGroup\ZfConsulServiceDiscoveryModule\ServiceDiscovery\ConsulController::class,
                            'action'     => 'register',
                        ],
                    ],
                ],
                'consul-sd-deregister' => [
                    'options' => [
                        'route'    => 'service-discovery consul deregister',
                        'defaults' => [
                            'controller' => \RstGroup\ZfConsulServiceDiscoveryModule\ServiceDiscovery\ConsulController::class,
                            'action'     => 'deregister',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
