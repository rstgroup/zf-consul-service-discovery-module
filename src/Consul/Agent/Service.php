<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent;


final class Service implements DefinitionInterface
{
    /** @var string */
    private $name;
    /** @var CheckInterface|null */
    private $check;

    /**
     * @param string              $name  service name
     * @param CheckInterface|null $check check definition
     */
    public function __construct($name, CheckInterface $check = null)
    {
        $this->name  = $name;
        $this->check = $check;
    }

    /** @inheritdoc */
    public function getDefinition()
    {
        $definition = [
            'Name' => $this->name,
        ];

        if ($this->check) {
            $definition['Check'] = $this->check->getDefinition();
        }

        return $definition;
    }
}
