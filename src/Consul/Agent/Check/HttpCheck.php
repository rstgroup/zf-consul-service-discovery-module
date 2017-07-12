<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent\Check;


use RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent\CheckInterface;


final class HttpCheck implements CheckInterface
{
    /** @var string */
    private $name;
    /** @var string */
    private $url;
    /** @var string */
    private $interval;

    /**
     * @param string $name     name of check
     * @param string $url      URL to check for availability
     * @param string $interval frequency to run the check
     *
     * @throws \InvalidArgumentException when given interval is invalid
     */
    public function __construct($name, $url, $interval = '1m')
    {
        $this->validateInterval($interval);

        $this->name     = $name;
        $this->url      = $url;
        $this->interval = $interval;
    }

    /** @return array */
    public function getDefinition()
    {
        return [
            'Name'     => $this->name,
            'HTTP'     => $this->url,
            'Interval' => $this->interval,
        ];
    }

    /**
     * @param string $interval
     *
     * @throws \InvalidArgumentException when given interval is invalid
     */
    private function validateInterval($interval)
    {
        if (!preg_match('/^[1-9][0-9]*(\.[0-9]+)?(h|m|s|ms|ns|us)$/', $interval)) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid interval specified: '%s'.",
                $interval
            ));
        }
    }
}
