<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Model;

/**
 * General wrapper for module configuration
 */
interface ConfigInterface
{
    /**
     * Return true if exception throwing is enabled
     *
     * @return bool
     */
    public function shouldThrowException();
}
