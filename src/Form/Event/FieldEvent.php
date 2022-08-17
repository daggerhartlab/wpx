<?php

namespace Wpx\Form\Event;

use Wpx\Form\Model\FieldTypeInterface;

class FieldEvent extends ControlEvent {

	/**
	 * @var FieldTypeInterface
	 */
	protected $field;

	/**
	 * @param FieldTypeInterface $field
	 */
	public function __construct( FieldTypeInterface $field ) {
		$this->field = $field;
		parent::__construct( $field );
	}

	/**
	 * @return FieldTypeInterface
	 */
	public function getField(): FieldTypeInterface {
		return $this->field;
	}

}
