<?php

namespace Wpx\Form\Model\Field;

use Wpx\Form\Model\ElementInterface;
use Wpx\Form\Model\FieldBase;

class Input extends FieldBase {

	/**
	 * @param ElementInterface $element
	 * @param string $name
	 * @param string $label
	 */
	public function __construct( ElementInterface $element, string $name = '', string $label = '' ) {
		$element->setTag('input');

		parent::__construct( $element, $name, $label );
	}

	/**
	 * @inheritDoc
	 */
	public function setType( string $type ) {
		$this->type = $type;
		$this->getElement()->setAttribute( 'type', $type );

		return $this;
	}

}
