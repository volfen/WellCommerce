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
namespace WellCommerce\Core\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Class AbstractCommand
 *
 * @package WellCommerce\Core\Console\Command
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractCommand extends Command
{
    protected function getMigrationClassesPath()
    {
        return ROOTPATH . 'application' . DS . 'WellCommerce' . DS . 'Core' . DS . 'Migration';
    }

    /**
     * Returns plugin directory
     *
     * @param $namespace
     * @param $plugin
     *
     * @return string
     */
    protected function getPluginDirectory($namespace, $plugin)
    {
        return ROOTPATH . 'application' . DS . $namespace . DS . 'Plugin' . DS . $plugin . DS;
    }

    protected function getFilesystem()
    {
        return $this->getApplication()->getContainer()->get('filesystem');
    }

    protected function getFinder()
    {
        return $this->getApplication()->getContainer()->get('finder');
    }

    protected function getDatabaseManager()
    {
        return $this->getApplication()->getContainer()->get('database_manager');
    }

    protected function createDirectory($directory, $chmod = 0700)
    {
        $filesystem = $this->getFilesystem();

        try {
            $filesystem->mkdir($directory, $chmod);
        } catch (IOException $e) {
            throw new IOException(sprintf('Unable to write the "%s" directory', $directory), 0, $e);
        }
    }
}