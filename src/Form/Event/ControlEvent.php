<?php

namespace Wpx\Form\Event;

use Wpx\Form\Model\ControlInterface;

class ControlEvent implements EventInterface {

	/**
	 * @var ControlInterface
	 */
	protected $control;

	/**
	 * @param ControlInterface $container
	 */
	public function __construct( ControlInterface $container ) {
		$this->control = $container;
	}

	/**
	 * @return ControlInterface
	 */
	public function getControl(): ControlInterface {
		return $this->control;
	}

}
