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

namespace WellCommerce\Core\Component\Form\Conditions;

use WellCommerce\Core\Component\Form\Condition;

/**
 * Class Equals
 *
 * @package WellCommerce\Core\Component\Form\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Equals extends Condition implements ConditionInterface
{
    /**
     * Checks whether given values are equal
     *
     * @param $value
     *
     * @return bool|mixed
     */
    public function evaluate($value)
    {
        if ($this->_argument instanceof Condition) {
            return false;
        }
        if (is_array($this->_argument)) {
            return in_array($value, $this->_argument);
        }

        return ($value == $this->_argument);
    }

}