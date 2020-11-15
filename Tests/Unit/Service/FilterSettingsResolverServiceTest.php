<?php
/**
 * @copyright Copyright (c)  netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Tests\Unit\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use N98\Guillotine\Api\FilterSettingsResolverInterface;
use N98\Guillotine\Service\FilterSettingsResolverService;
use PHPUnit_Framework_MockObject_MockObject as Mock;

/**
 * Test of service class FilterSettingsResolverService
 *
 * @covers \N98\Guillotine\Service\FilterSettingsResolverService
 */
class FilterSettingsResolverServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $settings
     * @param array $expectation
     *
     * @dataProvider dataProvider
     */
    public function test($settings, array $expectation)
    {
        $configMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->getMock();
        /* @var ScopeConfigInterface|Mock $configMock */

        $configMock
            ->expects($this->once())
            ->method('getValue')
            ->with($this->equalTo(FilterSettingsResolverInterface::SCOPE_CONFIG_WHITELIST_PATTERNS))
            ->willReturn($settings);

        $service = new FilterSettingsResolverService($configMock);

        $this->assertEquals($expectation, $service->execute());
    }

    public function dataProvider()
    {
        return [
            ["Test", ['Test']],
            ["Test\nTest", ['Test', 'Test']],
            ["Test\r\nTest", ['Test', 'Test']],
            ["\nTest\r\nTest\n", ['Test', 'Test']],
            ["", []]
        ];
    }
}
