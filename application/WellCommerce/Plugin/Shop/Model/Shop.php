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
namespace WellCommerce\Plugin\Shop\Model;

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\TranslatableModelInterface;

/**
 * Class Shop
 *
 * @package WellCommerce\Plugin\Shop\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class Shop extends AbstractModel implements TranslatableModelInterface
{

    protected $table = 'shop';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    /**
     * Relation with ShopTranslationModel model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function translation()
    {
        return $this->hasMany('WellCommerce\Plugin\Shop\Model\ShopTranslation');
    }

    /**
     * Relation with Company model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('WellCommerce\Plugin\Company\Model\Company');
    }

    /**
     * Mutator for offline attribute
     *
     * @param $value
     */
    public function setOfflineAttribute($value)
    {
        $this->attributes['offline'] = (int)$value;
    }

    /**
     * Accessor for offline attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getOfflineAttribute($value)
    {
        return (int)$value;
    }
}