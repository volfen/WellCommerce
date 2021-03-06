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
namespace WellCommerce\Plugin\Layout\Model;

use WellCommerce\Core\Component\Model\AbstractModel;

/**
 * Class LayoutPageColumn
 *
 * @package WellCommerce\Plugin\Layout\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutPageColumn extends AbstractModel
{

    protected $table = 'layout_page_column';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    public function box()
    {
        return $this->hasMany('WellCommerce\Plugin\Layout\Model\LayoutPageColumnBox');
    }
}