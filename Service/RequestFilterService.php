<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Service;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
use N98\Guillotine\Api\FilterSettingsResolverInterface;
use N98\Guillotine\Api\RequestFilterInterface;
use N98\Guillotine\Exception\NotAllowedException;
use N98\Guillotine\Model\ConfigInterface;

/**
 * Filters a request path against a whitelist
 */
class RequestFilterService implements RequestFilterInterface
{
    /**
     * @var \N98\Guillotine\Api\FilterSettingsResolverInterface
     */
    private $filterSettingsResolver;

    /**
     * @var \N98\Guillotine\Model\ConfigInterface
     */
    private $config;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    private $rawResultFactory;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    private $response;

    /**
     * RequestFilterService constructor.
     *
     * @param \N98\Guillotine\Api\FilterSettingsResolverInterface $filterSettingsResolver
     * @param \N98\Guillotine\Model\ConfigInterface $config
     * @param \Magento\Framework\App\ResponseInterface $response
     * @param \Magento\Framework\Controller\Result\RawFactory $rawResultFactory
     */
    public function __construct(
        FilterSettingsResolverInterface $filterSettingsResolver,
        ConfigInterface $config,
        ResponseInterface $response,
        RawFactory $rawResultFactory
    ) {
        $this->filterSettingsResolver = $filterSettingsResolver;
        $this->config = $config;
        $this->rawResultFactory = $rawResultFactory;
        $this->response = $response;
    }

    /**
     * @param string $requestPath
     *
     * @return void
     * @throws \N98\Guillotine\Exception\NotAllowedException
     */
    public function execute($requestPath)
    {
        $whitelistPatterns = $this->filterSettingsResolver->execute();
        foreach ($whitelistPatterns as $pattern) {
            $regex = sprintf('#%s#', trim($pattern));
            if (preg_match($regex, $requestPath, $matches)) {
                return;
            }
        }

        if ($this->config->shouldThrowException()) {
            throw NotAllowedException::notAllowed();
        }

        /** @var Raw $rawResult */
        $rawResult = $this->rawResultFactory->create();
        $rawResult->setContents(NotAllowedException::MSG_BLOCKED_DEFAULT);
        $rawResult->renderResult($this->response);
        $this->response->sendResponse();
    }
}
