<?php

namespace Wpx\Plugin;

use Psr\Container\ContainerInterface;

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
	public static function boostrap( ContainerInterface $container );

}
