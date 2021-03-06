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
namespace WellCommerce\Plugin\User\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WellCommerce\Core\Event\AdminMenuEvent;
use WellCommerce\Plugin\AdminMenu\Builder\AdminMenuItem;
use WellCommerce\Plugin\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class UserListener
 *
 * @package WellCommerce\Plugin\Category\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $builder = $event->getBuilder();

        $builder->add(new AdminMenuItem([
            'id'         => 'user_management',
            'name'       => $this->container->get('translation')->trans('User management'),
            'link'       => $this->container->get('router')->generate('admin.user.index'),
            'path'       => '[menu][configuration][user_management]',
            'sort_order' => 20
        ]));

        $builder->add(new AdminMenuItem([
            'id'         => 'user',
            'name'       => $this->container->get('translation')->trans('Users'),
            'link'       => $this->container->get('router')->generate('admin.user.index'),
            'path'       => '[menu][configuration][user_management][user]',
            'sort_order' => 10
        ]));

        $builder->add(new AdminMenuItem([
            'id'         => 'user_group',
            'name'       => $this->container->get('translation')->trans('User groups'),
            'link'       => $this->container->get('router')->generate('admin.user.index'),
            'path'       => '[menu][configuration][user_management][user_group]',
            'sort_order' => 20
        ]));
    }

    public static function getSubscribedEvents()
    {
        return array(
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent'
        );
    }
}