<?php

namespace Wpx\Plugin;

use Wpx\DependencyInjection\ContainerInterface;

/**
 * Interface PluginInterface.
 *
 * @package Wpx
 */
interface PluginInterface {

	/**
	 * Container.
	 *
	 * @param ContainerInterface $container Container.
	 */
	public static function bootstrap( ContainerInterface $container );

}
