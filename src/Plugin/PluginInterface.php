<?php

namespace Wpx\Plugin;

use Wpx\DependencyInjection\ContainerAwareInterface;
use Wpx\DependencyInjection\ContainerInterface;

/**
 * Interface PluginInterface.
 *
 * @package Wpx
 */
interface PluginInterface extends ContainerAwareInterface {

	/**
	 * Container.
	 *
	 * @param ContainerInterface $container Container.
	 */
	public static function bootstrap( ContainerInterface $container );

}
