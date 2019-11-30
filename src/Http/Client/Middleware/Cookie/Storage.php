<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client\Middleware\Cookie;

use Dflydev\FigCookies\SetCookie;

interface Storage
{
    /**
     * @param SetCookie $setCookie
     */
    public function add(SetCookie $setCookie);

    /**
     * @return SetCookie[]
     */
    public function getAll();
}
