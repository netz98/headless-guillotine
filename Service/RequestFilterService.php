<?php
/**
 * @copyright Copyright (c)  netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Service;

use N98\Guillotine\Api\FilterSettingsResolverInterface;
use N98\Guillotine\Api\RequestFilterInterface;
use N98\Guillotine\Exception\NotAllowedException;

/**
 * Filters a request path agains a whitelist
 */
class RequestFilterService implements RequestFilterInterface
{
    /**
     * @var \N98\Guillotine\Api\FilterSettingsResolverInterface
     */
    private $filterSettingsResolver;

    /**
     * RequestFilterService constructor.
     *
     * @param \N98\Guillotine\Api\FilterSettingsResolverInterface $filterSettingsResolver
     */
    public function __construct(FilterSettingsResolverInterface $filterSettingsResolver)
    {
        $this->filterSettingsResolver = $filterSettingsResolver;
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

        throw NotAllowedException::notAllowed();
    }
}
