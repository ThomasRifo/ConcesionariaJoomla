<?php
/**
 * @package         Sourcerer
 * @version         12.2.6
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            https://regularlabs.com
 * @copyright       Copyright © 2025 Regular Labs All Rights Reserved
 * @license         GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use RegularLabs\Plugin\EditorButton\Sourcerer\Extension\Sourcerer;
use RegularLabs\Plugin\EditorButton\Sourcerer\Extension\SourcererJ4;

defined('_JEXEC') or die;

if (version_compare(JVERSION, 4, '<') || version_compare(JVERSION, 7, '>='))
{
    return;
}

if ( ! is_file(JPATH_LIBRARIES . '/regularlabs/regularlabs.xml')
    || ! class_exists('RegularLabs\Library\Plugin\EditorButton')
)
{
    return;
}

return new class () implements ServiceProviderInterface {
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $class      = JVERSION < 5 ? SourcererJ4::class : Sourcerer::class;
                $dispatcher = $container->get(DispatcherInterface::class);

                $plugin = new $class(
                    $dispatcher,
                    (array) PluginHelper::getPlugin('editors-xtd', 'sourcerer')
                );
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};
