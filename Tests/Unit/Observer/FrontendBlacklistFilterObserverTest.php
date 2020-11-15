<?php
/**
 * @copyright Copyright (c) 1999-2017 netz98 GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Tests\Unit\Observer;

use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use N98\Guillotine\Api\RequestFilterInterface;
use N98\Guillotine\Observer\FrontendBlacklistFilterObserver;
use PHPUnit_Framework_MockObject_MockObject as Mock;

/**
 * Test of class FrontendBlacklistFilterObserver
 *
 * @covers \N98\Guillotine\Observer\FrontendBlacklistFilterObserver
 */
class FrontendBlacklistFilterObserverTest extends \PHPUnit_Framework_TestCase
{
    const TEST_PATH = '/test/path';

    public function test()
    {
        $filterMock = $this->getMockBuilder(RequestFilterInterface::class)
            ->getMock();
        /* @var $filterMock RequestFilterInterface|Mock */

        $filterMock
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo(self::TEST_PATH));

        $observerMock = $this->getMockBuilder(Observer::class)
            ->disableOriginalConstructor()
            ->setMethods(['getEvent'])
            ->getMock();
        /* @var $observerMock Observer|Mock */

        $eventMock = $this->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDataByKey'])
            ->getMock();
        /* @var $eventMock Event|Mock */

        $observerMock
            ->expects($this->once())
            ->method('getEvent')
            ->willReturn($eventMock);

        $requestMock = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPathInfo'])
            ->getMock();

        $requestMock
            ->expects($this->once())
            ->method('getPathInfo')
            ->willReturn(self::TEST_PATH);

        $eventMock
            ->expects($this->once())
            ->method('getDataByKey')
            ->with($this->equalTo('request'))
            ->willReturn($requestMock);

        $observer = new FrontendBlacklistFilterObserver($filterMock);
        $observer->execute($observerMock);
    }
}
