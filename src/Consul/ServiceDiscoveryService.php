<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Consul;


use RstGroup\ServiceDiscovery\Exception\ServiceDiscoveryException;
use RstGroup\ServiceDiscovery\ServiceDiscovery;
use RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent\Service;
use SensioLabs\Consul\Services\AgentInterface;

final class ServiceDiscoveryService implements ServiceDiscovery
{
    /** @var  AgentInterface */
    private $consulAgent;

    public function __construct(AgentInterface $agent)
    {
        $this->consulAgent = $agent;
    }

    /**
     * @param string $serviceName Consul requires the service name
     * @param        array        (
     *      'id'    (optional) service ID; if not given - the serviceName becomes ID
     * ) $options
     *
     * @return mixed
     *
     * @throws ServiceDiscoveryException
     */
    public function register($serviceName, array $options = [])
    {
        $service = new Service($serviceName, $options['id'] ?: '');

        try {
            $this->consulAgent->registerService($service->getDefinition());
        } catch (\Exception $exception) {
            throw new ServiceDiscoveryException(sprintf(
                "Problem occurred while registering service '%s'.",
                $serviceName
            ), 0, $exception);
        }
    }

    /**
     * @param string $serviceId service ID returned by register() function
     * @param array  $options   no additional options required here!
     *
     * @return mixed
     *
     * @throws ServiceDiscoveryException
     */
    public function deregister($serviceId, array $options = [])
    {
        try {
            $this->consulAgent->deregisterService($serviceId);
        } catch (\Exception $exception) {
            throw new ServiceDiscoveryException(sprintf(
                "Problem occurred while registering service '%s'.",
                $serviceId
            ), 0, $exception);
        }
    }
}
