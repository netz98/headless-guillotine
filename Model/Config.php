<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * General wrapper for module configuration
 */
class Config implements ConfigInterface
{
    const XML_PATH_THROW_EXCEPTION = 'n98_headless/guillotine/throw_exception';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Return true if exception throwing is enabled
     *
     * @return bool
     */
    public function shouldThrowException()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_THROW_EXCEPTION);
    }
}
