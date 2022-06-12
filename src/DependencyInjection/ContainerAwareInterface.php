<?php

namespace Wpx\DependencyInjection;

/**
 * ContainerAwareInterface should be implemented by classes that depends on a Container.
 */
interface ContainerAwareInterface {

	/**
	 * Sets the container.
	 */
	public function setContainer(ContainerInterface $container = null);

}
