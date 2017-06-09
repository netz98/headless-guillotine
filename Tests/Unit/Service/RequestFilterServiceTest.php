<?php
/**
 * @copyright Copyright (c) 1999-2017 netz98 GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Tests\Unit\Service;

use N98\Guillotine\Api\FilterSettingsResolverInterface;
use N98\Guillotine\Exception\NotAllowedException;
use N98\Guillotine\Service\RequestFilterService;
use PHPUnit_Framework_MockObject_MockObject as Mock;

/**
 * Class RequestFilterServiceTest
 *
 * @covers \N98\Guillotine\Service\RequestFilterService
 */
class RequestFilterServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestFilterService
     */
    private $service;

    /**
     * @inheritdoc
     */
    public function setUp()
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

        $this->service = new RequestFilterService($resolverMock);
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
            $this->setExpectedException(NotAllowedException::class);
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
