# ZF Consul Service Discovery Module

This module provides logic that allows the application to register itself in
Consul's Service Discovery.

## Requirements

1. PHP: 5.6 or 7.X
2. ZF3-compatible application
3. reachable Consul Agent API

## Installation

You have to add the repository to your `composer.json` file:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@gitlab.trans-dev.loc:devops/zf-consul-service-discovery-module.git"
        }
    ]
}
```

...and require module with Composer:

```bash
composer require rstgroup/zf-consul-service-discovery-module
```

The last step is adding module to ZF system configuration (`config/application.config.php`):
```php
return [
    'modules' => [
        (...),
        'RstGroup\ZfConsulServiceDiscoveryModule',
    ],
    (...)
]
```

.. and (optionally, but we strongly suggest it) - [install `rstgroup/zf-external-config-module`](https://gitlab.trans-dev.loc/devops/zf-external-config-module/blob/master/README.md#installation).

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
            ],
        ],
    ],
];
```

> We suggest using `rstgroup/zf-external-config-module` to pass `rst_group.service_discovery.consul.url` key during
  the provisioning stage - as infrastructure configuration should not be stored in application's
  repository.

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
