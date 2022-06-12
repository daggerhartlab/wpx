<?php

namespace Wpx\DependencyInjection;

/**
 * ContainerAware trait.
 * Useful when implementing ContainerAwareInterface.
 */
trait ContainerAwareTrait
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param ContainerInterface|null $container
	 *
	 * @return void
	 */
	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}

}
