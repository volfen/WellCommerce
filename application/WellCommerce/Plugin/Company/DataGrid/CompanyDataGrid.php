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
namespace WellCommerce\Plugin\Company\DataGrid;

use WellCommerce\Core\Component\DataGrid\AbstractDataGrid;
use WellCommerce\Core\Component\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\Component\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;

/**
 * Class CompanyDataGrid
 *
 * @package WellCommerce\Plugin\Company\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [
            'edit' => $this->generateUrl('admin.company.edit')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function initColumns()
    {
        $this->columns->add(new DataGridColumn([
            'id'         => 'id',
            'source'     => 'company.id',
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
            'id'         => 'name',
            'source'     => 'company.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 70,
                'align' => ColumnInterface::ALIGN_LEFT
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
        $this->query = $this->getDb()->table('company');
        $this->query->groupBy('company.id');
    }
}