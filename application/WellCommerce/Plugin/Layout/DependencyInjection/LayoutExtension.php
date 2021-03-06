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

namespace WellCommerce\Plugin\Layout\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class LayoutThemeExtension
 *
 * @package WellCommerce\Plugin\LayoutTheme\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutExtension extends AbstractExtension
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
        // LayoutTheme

        $layoutThemeCollection = new RouteCollection();

        $layoutThemeCollection->add('admin.layout_theme.index', new Route('/index', array(
            '_controller' => 'language.admin.controller:indexAction',
        )));

        $layoutThemeCollection->add('admin.layout_theme.add', new Route('/add', array(
            '_controller' => 'language.admin.controller:addAction',
        )));

        $layoutThemeCollection->add('admin.layout_theme.edit', new Route('/edit/{id}', array(
            '_controller' => 'language.admin.controller:editAction',
            'id'          => null
        )));

        $layoutThemeCollection->addPrefix('/admin/layout/theme');

        // LayoutBox

        $layoutBoxCollection = new RouteCollection();

        $layoutBoxCollection->add('admin.layout_box.index', new Route('/index', array(
            '_controller' => 'layout_box.admin.controller:indexAction',
        )));

        $layoutThemeCollection->add('admin.layout_box.add', new Route('/add', array(
            '_controller' => 'layout_box.admin.controller:addAction',
        )));

        $layoutThemeCollection->add('admin.layout_box.edit', new Route('/edit/{id}', array(
            '_controller' => 'layout_box.admin.controller:editAction',
            'id'          => null
        )));

        $layoutThemeCollection->addPrefix('/admin/layout/box');

        // LayoutPage

        $layoutPageCollection = new RouteCollection();

        $layoutPageCollection->add('admin.layout_page.index', new Route('/index', array(
            '_controller' => 'language.admin.controller:indexAction',
        )));

        $layoutPageCollection->add('admin.layout_page.add', new Route('/add', array(
            '_controller' => 'language.admin.controller:addAction',
        )));

        $layoutPageCollection->add('admin.layout_page.edit', new Route('/edit/{id}', array(
            '_controller' => 'language.admin.controller:editAction',
            'id'          => null
        )));

        $layoutPageCollection->addPrefix('/admin/layout/page');

        // merge collections

        $collection->addCollection($layoutThemeCollection);
        $collection->addCollection($layoutPageCollection);
        $collection->addCollection($layoutBoxCollection);
    }
}