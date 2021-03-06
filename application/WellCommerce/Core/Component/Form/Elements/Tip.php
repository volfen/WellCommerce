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

namespace WellCommerce\Core\Component\Form\Elements;

use WellCommerce\Core\Component\Form\Node;

/**
 * Class Tip
 *
 * @package WellCommerce\Core\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Tip extends Node implements ElementInterface
{

    const UP   = 'up';
    const DOWN = 'down';

    const EXPANDED  = 'expanded';
    const RETRACTED = 'retracted';

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->attributes['name'] = '';
        if (isset($this->attributes['short_tip']) && strlen($this->attributes['short_tip'])) {
            $this->attributes['retractable'] = true;
        }
    }

    public function prepareAttributesJs()
    {
        $attributes = Array(
            $this->formatAttributeJs('tip', 'sTip'),
            $this->formatAttributeJs('direction', 'sDirection'),
            $this->formatAttributeJs('short_tip', 'sShortTip'),
            $this->formatAttributeJs('retractable', 'bRetractable', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('default_state', 'sDefaultState'),
            $this->formatDependencyJs()
        );

        return $attributes;
    }

    public function renderStatic()
    {
    }

    public function populate($value)
    {
    }

}
