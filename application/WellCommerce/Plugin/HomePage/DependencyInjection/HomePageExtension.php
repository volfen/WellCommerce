<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This home_page is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE home_page that was distributed with this source code.
 */
namespace WellCommerce\Plugin\HomePage\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class HomePageExtension
 *
 * @package WellCommerce\Plugin\HomePage\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class HomePageExtension extends AbstractExtension
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

        $extensionCollection->add('admin.home_page.index', new Route('/index', array(
            '_controller' => 'home_page.admin.controller:indexAction',
        )));

        $extensionCollection->addPrefix('/');

        $collection->addCollection($extensionCollection);
    }
}