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
namespace WellCommerce\Plugin\AdminMenu\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\AdminMenu\Model\AdminMenu;

/**
 * Class AdminMenuRepository
 *
 * @package WellCommerce\Plugin\AdminMenu\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuRepository extends AbstractRepository implements RepositoryInterface
{

    public function delete($id)
    {

    }

    public function save(array $Data, $id = null)
    {

    }

    public function find($id)
    {

    }

    /**
     * Returns a admin menu collection
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return AdminMenu::all();
    }

    /**
     * Admin menu sorting function
     *
     * @param $a
     * @param $b
     *
     * @return int
     */
    private function sortMenu(&$a, &$b)
    {
        if (!empty($a['children'])) {
            usort($a['children'], [$this, 'sortMenu']);
        }
        if ($a['sort_order'] == $b['sort_order']) {
            return 0;
        }

        return $a['sort_order'] > $b['sort_order'] ? 1 : -1;
    }

    /**
     * Returns admin menu sorted by sort_order value
     *
     * @return array
     */

    public function getMenuData()
    {
        $this->menuData     = $this->all();
        $this->currentRoute = $this->getRequest()->attributes->get('_route');
        $tree               = $this->parseMenuTree();

        usort($tree, [$this, 'sortMenu']);

        return $tree;
    }

    /**
     * Parses and returns menu tree
     *
     * @param null $parent
     *
     * @return array
     */
    protected function parseMenuTree($parent = null)
    {
        $menuItems = [];
        foreach ($this->menuData as $menu) {
            if ($parent == null) {
                if ($menu['parent_id'] != '') {
                    continue;
                }
            } elseif ($menu['parent_id'] != $parent) {
                continue;
            }

            $menuItems[] = [
                'id'         => $menu['id'],
                'icon'       => $menu['icon'],
                'name'       => $this->trans($menu['name']),
                'sort_order' => $menu['sort_order'],
                'link'       => (null !== $menu['route']) ? $this->generateUrl($menu['route']) : '',
                'active'     => (bool)($this->currentRoute == $menu['route']),
                'children'   => $this->parseMenuTree($menu['id']),
            ];
        }

        return $menuItems;
    }

    public function getRootItems(){
        return [
            'Dashboard', 'dashboard', NULL, NULL, '0', NULL
'Catalog', 'catalog', NULL, NULL, '10', NULL
'Promotions', 'promotion', NULL, NULL, '20', NULL
'Sales', 'sales', NULL, NULL, '30', NULL
'Reports', 'reports', NULL, NULL, '40', NULL
'CRM', 'crm', NULL, NULL, '50', NULL
'CMS', 'cms', NULL, NULL, '60', NULL
'Layout settings', 'layout', NULL, NULL, '70', NULL
'Integration', 'external', NULL, NULL, '80', NULL
'Configuration', 'configuration', NULL, NULL, '90', NULL

        ];
    }
}