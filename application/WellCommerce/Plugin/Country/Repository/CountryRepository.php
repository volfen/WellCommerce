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
namespace WellCommerce\Plugin\Country\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use Symfony\Component\Intl\Intl;

/**
 * Class CountryAbstractRepository
 *
 * @package WellCommerce\Plugin\Country\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CountryRepository extends AbstractRepository
{

    /**
     * Returns all country names for given locale
     *
     * @param string $locale
     *
     * @return \string[]
     */
    public function all($locale = 'en')
    {
        return Intl::getRegionBundle()->getCountryNames($locale);
    }
}