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
namespace WellCommerce\Core\Template\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AssetExtension
 *
 * Provides simplier asset linking in Twig
 *
 * @package WellCommerce\Core\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AssetExtension extends \Twig_Extension
{

    protected $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns array containing all functions used by this extension
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('asset', [$this, 'getAsset'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Gets assets path
     *
     * @param $path
     *
     * @return string
     */
    public function getAsset($path)
    {
        return sprintf('%s/%s', $this->container->get('request')->getSchemeAndHttpHost(), $path);
    }

    /**
     * Returns unique extensions name
     *
     * @return string
     */
    public function getName()
    {
        return 'asset';
    }
}
