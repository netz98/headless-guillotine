<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Api;

/**
 * Interface RequestFilterInterface
 *
 * @api
 */
interface RequestFilterInterface
{
    /**
     * @param string $requestPath
     *
     * @return void
     * @throws \N98\Guillotine\Exception\NotAllowedException
     */
    public function execute($requestPath);
}
