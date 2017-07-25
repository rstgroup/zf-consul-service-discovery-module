<?php


namespace RstGroup\ZfConsulServiceDiscoveryModule\Tests\Consul\Agent\Check;


use RstGroup\ZfConsulServiceDiscoveryModule\Consul\Agent\Check\HttpCheck;


class HttpCheckTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider  invalidIntervals
     *
     * @param string $invalidInterval
     */
    public function testItThrowsExceptionOnInvalidInterval($invalidInterval)
    {
        // expect:
        $this->expectException(\InvalidArgumentException::class);

        // when
        new HttpCheck('name', 'http://localhost/check', $invalidInterval);
    }

    public function invalidIntervals()
    {
        return [
            'invalid decimal separator' => ['1,5h'],
            'number with spaces' => ['1 000 000ns'],
            'no decimal part after decimal separator' => ['2,ms'],
        ];
    }

    /**
     * @dataProvider validIntervals
     *
     * @param string $validInterval
     */
    public function testItAcceptsInterval($validInterval)
    {
        // when
        $check = new HttpCheck('name', 'http://localhost/check', $validInterval);

        // then
        $this->assertArraySubset(['Interval' => $validInterval], $check->getDefinition());
    }

    public function validIntervals()
    {
        return [
            ['1m'],
            ['30s'],
            ['10.5h'],
            ['300ms'],
            ['600000ns']
        ];
    }
}
