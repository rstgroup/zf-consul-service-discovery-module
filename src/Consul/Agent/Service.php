<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent;


use Webmozart\Assert\Assert;

final class Service implements DefinitionInterface
{
    /** @var string */
    private $name;
    /** @var string */
    private $id;
    /** @var CheckInterface|null */
    private $check;
    /** @var string[] */
    private $tags;

    /**
     * @param string              $name  service name
     * @param string              $id    service identifier
     * @param string[]            $tags  consul tags for service
     * @param CheckInterface|null $check check definition
     *
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($name, $id = '', array $tags = [], CheckInterface $check = null)
    {
        Assert::stringNotEmpty($name);
        Assert::string($id);
        Assert::allStringNotEmpty($tags);

        $this->name  = $name;
        $this->check = $check;
        $this->id    = $id;
        $this->tags  = $tags;
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

        if (!empty($this->tags)) {
            $definition['Tags'] = $this->tags;
        }

        return $definition;
    }
}
