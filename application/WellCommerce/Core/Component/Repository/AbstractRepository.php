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
namespace WellCommerce\Core\Component\Repository;

use Closure;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Event\RepositoryEvent;

/**
 * Class AbstractRepository
 *
 * Provides methods needed in repositories
 *
 * @package WellCommerce\Core\Component\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRepository extends AbstractComponent
{
    /**
     * Wraps callback function into DB transaction
     *
     * @param callable $callback
     *
     * @return mixed
     */
    final protected function transaction(Closure $callback)
    {
        return $this->container->get('database_manager')->getConnection()->transaction($callback);
    }

    /**
     * Dispatches the event for repository action
     *
     * @param       $eventName
     * @param array $data
     * @param       $id
     */
    final protected function dispatchEvent($eventName, array $data, $id)
    {
        $event = new RepositoryEvent($data, $id);
        $this->getDispatcher()->dispatch($eventName, $event);

        return $event->getData();
    }
}