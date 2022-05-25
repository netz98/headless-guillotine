<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
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
    public const SCOPE_CONFIG_WHITELIST_PATTERNS = 'n98_headless/guillotine/whitelist_patterns';

    /**
     * Execute filter settings resolver
     *
     * @return string[]
     */
    public function execute();
}
