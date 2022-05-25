<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98\Guillotine\Test\Unit\Exception;

use N98\Guillotine\Exception\NotAllowedException;

/**
 * Test of class NotAllowedException
 *
 * @covers \N98\Guillotine\Exception\NotAllowedException
 */
class NotAllowedExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string|null $msg
     *
     * @dataProvider dataProvider
     */
    public function test($msg)
    {
        try {
            throw NotAllowedException::notAllowed($msg);
        } catch (NotAllowedException $exception) {
            $this->assertEquals($msg ?: NotAllowedException::MSG_BLOCKED_DEFAULT, $exception->getRawMessage());
        }
    }

    /**
     * @return array[]
     */
    public function dataProvider()
    {
        return [
            [null],
            ['This is a test with a custom message.'],
        ];
    }
}
