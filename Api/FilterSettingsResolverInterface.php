<?php
/**
 * @copyright Copyright (c)  netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Api;

/**
 * Interface FilterSettingsResolverInterface
 *
 * @api
 */
interface FilterSettingsResolverInterface
{
    const SCOPE_CONFIG_WHITELIST_PATTERNS = 'n98_headless/guillotine/whitelist_patterns';

    /**
     * @return string[]
     */
    public function execute();
}
