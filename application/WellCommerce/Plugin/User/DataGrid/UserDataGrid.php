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
namespace WellCommerce\Plugin\User\DataGrid;

use WellCommerce\Core\Component\DataGrid\AbstractDataGrid;
use WellCommerce\Core\Component\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\Component\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;

/**
 * Class UserDataGrid
 *
 * @package WellCommerce\Plugin\User\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [
            'edit' => $this->generateUrl('admin.user.edit')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function initColumns()
    {
        $this->columns->add(new DataGridColumn([
            'id'         => 'id',
            'source'     => 'user.id',
            'caption'    => $this->trans('Id'),
            'sorting'    => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance' => [
                'width'   => 90,
                'visible' => false
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $this->columns->add(new DataGridColumn([
            'id'         => 'first_name',
            'source'     => 'user.first_name',
            'caption'    => $this->trans('First name'),
            'appearance' => [
                'width' => 70
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $this->columns->add(new DataGridColumn([
            'id'         => 'last_name',
            'source'     => 'user.last_name',
            'caption'    => $this->trans('Last name'),
            'appearance' => [
                'width' => 70
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $this->columns->add(new DataGridColumn([
            'id'         => 'email',
            'source'     => 'user.email',
            'caption'    => $this->trans('E-mail'),
            'appearance' => [
                'width' => 70
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

    }

    /**
     * {@inheritdoc}
     */
    public function setQuery()
    {
        $this->query = $this->getDb()->table('user');
        $this->query->groupBy('user.id');
    }
}
