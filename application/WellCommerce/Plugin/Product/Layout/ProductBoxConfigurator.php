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

namespace WellCommerce\Plugin\Product\Layout;

use WellCommerce\Core\Component\Form\Elements\Fieldset;
use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class ProductBoxConfigurator
 *
 * @package WellCommerce\Plugin\Product\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    public function getName()
    {
        return 'Product';
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        return ($layoutPage == 'Product');
    }

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(Fieldset $fieldset)
    {
        $fieldset->addChild($this->addTip([
            'tip' => '<p>' . $this->trans('This layout box does not need to be configured. All done :).') . '</p>'
        ]));
    }
} 