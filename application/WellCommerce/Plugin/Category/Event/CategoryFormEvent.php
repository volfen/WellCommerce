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
namespace WellCommerce\Plugin\Category\Event;

use WellCommerce\Core\Event\FormEvent;

/**
 * Class CategoryFormEvent
 *
 * @package WellCommerce\Plugin\Category\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CategoryFormEvent extends FormEvent
{

    const FORM_INIT_EVENT = 'category.form.init';

    const TREE_INIT_EVENT = 'category.tree.init';
}