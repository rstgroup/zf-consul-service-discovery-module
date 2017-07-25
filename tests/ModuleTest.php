<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Tests;


use RstGroup\ZfConsulServiceDiscoveryModule\Module;


class ModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testItReturnsDefaultConfiguration()
    {
        // given: module
        $module = new Module();

        // when:
        $config = $module->getConfig();

        // then:
        $this->assertInternalType('array', $config);
    }
}
