<?php

namespace Wpx\Form\Event;

use Wpx\Form\Model\ElementInterface;

class ElementEvent implements EventInterface {

	/**
	 * @var ElementInterface
	 */
	protected $element;

	/**
	 * @param ElementInterface $element
	 */
	public function __construct( ElementInterface $element ) {
		$this->element = $element;
	}

	/**
	 * @return ElementInterface
	 */
	public function getElement(): ElementInterface {
		return $this->element;
	}

}
