<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Exception;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

/**
 * Exception in case of blocked requests
 *
 * @api
 */
class NotAllowedException extends LocalizedException
{
    public const MSG_BLOCKED_DEFAULT = 'The requested page is blocked.';

    /**
     * Throw notAllowed exception
     *
     * @param Phrase|null $msg
     * @return \N98\Guillotine\Exception\NotAllowedException
     * phpcs:disable Magento2.Functions.StaticFunction
     */
    public static function notAllowed($msg = null)
    {
        return new self(new Phrase($msg ?: self::MSG_BLOCKED_DEFAULT));
    }
}
