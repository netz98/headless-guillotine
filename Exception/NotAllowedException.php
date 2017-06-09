<?php
/**
 * @copyright Copyright (c) 1999-2017 netz98 GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Exception;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

/**
 * Class NotAllowedException
 *
 * @api
 */
class NotAllowedException extends LocalizedException
{
    const MSG_BLOCKED_DEFAULT = 'The requested page is blocked.';

    /**
     * @param Phrase|null $msg
     *
     * @return \N98\Guillotine\Exception\NotAllowedException
     */
    public static function notAllowed($msg = null)
    {
        return new self(new Phrase($msg ?: self::MSG_BLOCKED_DEFAULT));
    }
}
