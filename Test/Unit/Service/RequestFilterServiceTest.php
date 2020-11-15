<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Test\Unit\Service;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
use N98\Guillotine\Api\FilterSettingsResolverInterface;
use N98\Guillotine\Exception\NotAllowedException;
use N98\Guillotine\Model\ConfigInterface;
use N98\Guillotine\Service\RequestFilterService;
use PHPUnit_Framework_MockObject_MockObject as Mock;

/**
 * Test of service class RequestFilterService
 *
 * @covers \N98\Guillotine\Service\RequestFilterService
 */
class RequestFilterServiceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var RequestFilterService
     */
    private $service;
    private $configMock;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $resolverMock = $this->getMockBuilder(FilterSettingsResolverInterface::class)
            ->getMock();
        /* @var $resolverMock FilterSettingsResolverInterface|Mock */

        $resolverMock
            ->expects($this->once())
            ->method('execute')
            ->willReturn(
                [
                    '^/rest/.*$',
                    '^/(swagger|(swagger/.*))$',
                ]
            );

        $this->configMock = $this->createMock(ConfigInterface::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $rawFactoryMock = $this->createMock(RawFactory::class);
        $rawFactoryMock->method('create')->willReturn($this->createMock(Raw::class));

        $this->service = new RequestFilterService(
            $resolverMock,
            $this->configMock,
            $responseMock,
            $rawFactoryMock
        );
    }

    /**
     * @param string $requestPath
     * @param bool $expectException
     *
     * @dataProvider dataProvider
     */
    public function test($requestPath, $expectException)
    {
        if ($expectException) {
            $this->configMock->method('shouldThrowException')->willReturn(true);
            $this->expectException(NotAllowedException::class);
        } else {
            $this->configMock->method('shouldThrowException')->willReturn(false);
        }

        $this->service->execute($requestPath);
    }

    /**
     * @return array[]
     */
    public function dataProvider()
    {
        return [
            ['/', true],
            ['/cart', true],
            ['/checkout', true],
            ['/rest', true],
            ['/rest/', false],
            ['/rest/?parameters=are&cool=true', false],
            ['/rest/test', false],
            ['/swagger', false],
            ['/swagger/', false],
            ['/swagger/test', false],
            ['/swagger/test?parameters=are&cool=true', false],
        ];
    }
}
