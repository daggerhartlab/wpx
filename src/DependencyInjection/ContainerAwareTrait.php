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
	 * Set the container.
	 *
	 * @param ContainerInterface|null $container
	 *
	 * @return void
	 */
	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}

	/**
	 * Get the container.
	 *
	 * @return ContainerInterface
	 */
	public function getContainer(): ContainerInterface {
		return $this->container;
	}

}
