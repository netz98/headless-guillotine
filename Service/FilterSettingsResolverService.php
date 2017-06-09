<?php
/**
 * @copyright Copyright (c) 1999-2017 netz98 GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use N98\Guillotine\Api\FilterSettingsResolverInterface;

/**
 * Class FilterSettingsResolverService
 */
class FilterSettingsResolverService implements FilterSettingsResolverInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * FilterSettingsResolverService constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string[]
     */
    public function execute()
    {
        $data = array_map(
            'trim',
            explode(
                "\n",
                (string)$this->scopeConfig->getValue(self::SCOPE_CONFIG_WHITELIST_PATTERNS)
            )
        );

        return array_values(
            array_filter($data)
        );
    }
}
