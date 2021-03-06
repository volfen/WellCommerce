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
namespace WellCommerce\Core\Component\Form;

use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\Model\ModelInterface;

/**
 * Class AbstractForm
 *
 * @package WellCommerce\Core\Component\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractForm extends AbstractComponent
{
    /**
     * {@inheritdoc}
     */
    public function prepareData(ModelInterface $model)
    {
        return [];
    }
}