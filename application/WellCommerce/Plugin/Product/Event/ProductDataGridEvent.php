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
namespace WellCommerce\Plugin\Product\Event;

use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class ProductDataGridEvent
 *
 * @package WellCommerce\Plugin\Product\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ProductDataGridEvent extends DataGridEvent
{
    const DATAGRID_INIT_EVENT = 'product.datagrid.init';
}