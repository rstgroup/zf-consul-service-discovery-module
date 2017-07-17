<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent;


final class Service implements DefinitionInterface
{
    /** @var string */
    private $name;
    /** @var string */
    private $id;
    /** @var CheckInterface|null */
    private $check;

    /**
     * @param string              $name  service name
     * @param string              $id    service identifier
     * @param CheckInterface|null $check check definition
     */
    public function __construct($name, $id = '', CheckInterface $check = null)
    {
        $this->name  = $name;
        $this->check = $check;
        $this->id    = $id;
    }

    /** @inheritdoc */
    public function getDefinition()
    {
        $definition = [
            'Name' => $this->name,
            'Id'   => $this->id ?: $this->name,
        ];

        if ($this->check) {
            $definition['Check'] = $this->check->getDefinition();
        }

        return $definition;
    }
}
