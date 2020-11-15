<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use N98\Guillotine\Api\RequestFilterInterface;

/**
 * Observer to filter frontend requests
 */
class FrontendBlacklistFilterObserver implements ObserverInterface
{
    /**
     * @var \N98\Guillotine\Api\RequestFilterInterface
     */
    private $requestFilter;

    /**
     * FrontendBlacklistFilterObserver constructor.
     *
     * @param \N98\Guillotine\Api\RequestFilterInterface $requestFilter
     */
    public function __construct(RequestFilterInterface $requestFilter)
    {
        $this->requestFilter = $requestFilter;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $request = $observer->getEvent()->getDataByKey('request');
        /* @var $request \Magento\Framework\App\Request\Http */

        $this->requestFilter->execute($request->getPathInfo());
    }
}
