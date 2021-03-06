<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Core\Helper;

use Hautelook\Phpass\PasswordHash;

/**
 * Class Password
 *
 * @package WellCommerce\Core\Helper
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Password
{
    CONST ITERATION_COUNT = 8;

    /**
     * Hashes password using Phpass library
     *
     * @param $password Password to hash
     *
     * @return string
     */
    public static function hash($password)
    {
        $passwordHasher = new PasswordHash(self::ITERATION_COUNT, false);
        $password       = $passwordHasher->HashPassword($password);

        return $password;
    }

    /**
     * Checks whether password matches hashed one
     *
     * @param $password
     * @param $hashed
     *
     * @return bool
     */
    public static function match($password, $hashed)
    {
        $passwordHasher = new PasswordHash(self::ITERATION_COUNT, false);
        $match          = $passwordHasher->CheckPassword($password, $hashed);

        return $match;
    }


} 