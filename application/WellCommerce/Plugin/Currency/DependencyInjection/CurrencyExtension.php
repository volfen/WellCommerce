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
namespace WellCommerce\Plugin\Currency\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class CurrencyExtension
 *
 * @package WellCommerce\Plugin\Currency\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function registerRoutes(RouteCollection $collection)
    {
        $extensionCollection = new RouteCollection();

        $extensionCollection->add('admin.currency.index', new Route('/index', array(
            '_controller' => 'currency.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.currency.add', new Route('/add', array(
            '_controller' => 'currency.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.currency.edit', new Route('/edit/{id}', array(
            '_controller' => 'currency.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->addPrefix('/admin/currency');

        $collection->addCollection($extensionCollection);
    }
}