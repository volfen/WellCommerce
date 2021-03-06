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

namespace WellCommerce\Plugin\AdminMenu\Builder;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class AdminMenuBuilder
 *
 * @package WellCommerce\Plugin\AdminMenu\Builder
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuBuilder implements \IteratorAggregate, \Countable, AdminMenuBuilderInterface
{
    private $items = [];

    /**
     * Returns iterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Returns menu items count
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Returns all columns
     *
     * @return mixed
     */
    public function all()
    {
        return $this->items;
    }

    public function getMenu()
    {
        $tree = $this->items['menu'];

        usort($tree, [$this, 'sortMenu']);

        return $tree;
    }

    public function sortMenu($a, $b)
    {
        $a->sortChildren();
        $b->sortChildren();

        if ($a->getSortOrder() == $b->getSortOrder()) {
            return 0;
        }
        return $a->getSortOrder() > $b->getSortOrder() ? 1 : -1;
    }

    /**
     * Adds new admin menu element
     *
     * @param AdminMenuItem $item Menu item
     * @param               $path Property path
     */
    public function add(AdminMenuItem $item)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->setValue($this->items, $item->getPath(), $item);
    }
}