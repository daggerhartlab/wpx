<?php

namespace Wpx\Form\Event;

use Wpx\Form\Model\FieldInterface;

class FieldEvent implements EventInterface {

	/**
	 * @var FieldInterface
	 */
	protected $field;

	/**
	 * @param FieldInterface $field
	 */
	public function __construct( FieldInterface $field ) {
		$this->field = $field;
	}

	/**
	 * @return FieldInterface
	 */
	public function getField(): FieldInterface {
		return $this->field;
	}

}
