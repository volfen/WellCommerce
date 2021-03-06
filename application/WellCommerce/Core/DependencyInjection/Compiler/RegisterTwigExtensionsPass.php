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
namespace WellCommerce\Core\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterTwigExtensionsPass
 *
 * @package WellCommerce\Core\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterTwigExtensionsPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     *
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process (ContainerBuilder $container)
    {
        if (! $container->hasDefinition('twig')){
            return;
        }
        
        $definition = $container->getDefinition('twig');
        
        foreach ($container->findTaggedServiceIds('twig.extension') as $id => $attributes){
            $class = $container->getDefinition($id)->getClass();
            $refClass = new \ReflectionClass($class);
            $interface = 'Twig_ExtensionInterface';
            if (! $refClass->implementsInterface($interface)){
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, $interface));
            }
            $definition->addMethodCall('addExtension', array(
                new Reference($id)
            ));
        }
    }
}