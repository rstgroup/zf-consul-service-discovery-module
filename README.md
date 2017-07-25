# ZF Consul Service Discovery Module

This module provides logic that allows the application to register itself in
Consul's Service Discovery.

[![Build Status](https://travis-ci.org/rstgroup/zf-consul-service-discovery-module.svg?branch=master)](https://travis-ci.org/rstgroup/zf-consul-service-discovery-module)

## Requirements

1. PHP: 5.6 or 7.X
2. ZF3-compatible application
3. reachable Consul Agent API

## Installation

Require module with Composer:

```bash
composer require rstgroup/zf-consul-service-discovery-module
```

The next step is adding module to ZF system configuration (`config/application.config.php`):
```php
return [
    'modules' => [
        (...),
        'RstGroup\ZfConsulServiceDiscoveryModule',
    ],
    (...)
]
```

.. and (optionally, but we strongly suggest it) - [install `rstgroup/zf-local-config-module`](https://packagist.org/packages/rstgroup/zf-local-config-module).

## Configuration

The module requires the presence of:
* Consul API URL
* service name
* service ID _(if service name is not unique across the same Consul Agent instance)_

Example configuration:

```php
return [
    'rst_group'       => [
        'service_discovery' => [
            'service_name' => 'my-service',
            'service_id'   => 'my-service-1',
            'consul'       => [
                'url' => 'http://consul-instance.loc:8500',
                'check' => [
                    'url' => 'http://my-service/check-endpoint',
                    'name' => 'check-endpoint',
                    'interval' => '30s',
                ],
                'tags' => [ 'service', 'httpd', 'php' ],
            ],
        ],
    ],
];
```

Minimal configuration:
```php
return [
    'rst_group'       => [
        'service_discovery' => [
            'service_name' => 'my-service',
            'consul'       => [
                'url' => 'http://consul-instance.loc:8500',
            ],
        ],
    ],
];
```

> We suggest using `rstgroup/zf-external-config-module` to pass `rst_group.service_discovery.consul.url` key during
  the provisioning stage - as infrastructure configuration should not be stored in application's
  repository. <br />
  
> If your service is about to be ran in many instances - then also its name should be passed during the provisioning state. 

## Usage

Module provides simple commands to register/deregister service in Consul Agent. Both of them are described when you run
`php public/index.php` with no arguments.

### Registering service in Consul Agent
In POST-install script:

0. _(optional)_ Provide required configuration for Consul Agent:
    ```bash
    php public/index.php local-config set rst_group.service_discovery.consul.url http://consul-instance.loc:8500
    ```
    Let's assume that service name and ID is already in configuration.
    
    > Remeber that this command requires you to have `rstgroup/zf-external-config-module` installed as well.

1. Register service:
    ```bash
   php public/index.php service-discovery consul register
    ```

### Deregistering service
IN POST-uninstall stage:

    ```bash
    php public/index.php service-discovery consul deregister
    ```

### Running commands with parameters
`service-discovery consul register` command has defined set of optional attributes that allows you to override
settings stored in your app's configuration. You can list the full usage information by simply typing:

`php public/index.php`

Here's the part that describes the `zf-consul-service-discovery-module`'s commands:

```
    -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    RstGroup\ZfConsulServiceDiscoveryMod
    -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    ZF Service Discovery - Consul
      index.php service-discovery consul register [--id=] [--name=] [--tags=] [--check] [--check-url=] [--check-name=] [--check-interval=]    Register service in Consul Agent's Service Discovery.                                       
    
      --id=               Override ID of service.                                                                                                                                                                                                               
      --name=             Override name of service.                                                                                                                                                                                                             
      --tags=             Override list of tags. Write tags as comma-separated list with no whitespaces.                                                                                                                                                                                            
      --check             If flag is set, the check is expected to be defined.                                                                                                                                                                                  
      --check-url         Override service's check URL                                                                                                                                                                                                          
      --check-name        Override service's check name                                                                                                                                                                                                         
      --check-interval    Override service's check interval                                                                                                                                                                                                     
    
      index.php service-discovery consul deregister [--id=]    Deregister service in Consul Agent' Service Discovery.                                                                                                                     
    
      --id=    Override ID of service. 
```
