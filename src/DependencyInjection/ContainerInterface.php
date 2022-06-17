<?php

namespace Wpx\DependencyInjection;

use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * Interface proxy for container.
 */
interface ContainerInterface extends PsrContainerInterface {

	/**
	 * Define an object or a value in the container.
	 *
	 * @param string $name
	 *   Entry name.
	 * @param mixed $value
	 *   Value, use definition helpers to define objects.
	 */
	public function set(string $name, $value);

}
