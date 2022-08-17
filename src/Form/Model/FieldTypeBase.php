<?php

namespace Wpx\Form\Model;

abstract class FieldTypeBase extends ControlBase implements FieldTypeInterface {

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @var bool
	 */
	protected $required = false;

	/**
	 * @param ElementInterface $element
	 * @param string $name
	 * @param string $label
	 */
	public function __construct( ElementInterface $element, string $name = '', string $label = '' ) {
		$element->setTag( static::defaultElementTag() );

		parent::__construct( $element, $name, $label );
	}

	/**
	 * @inheritDoc
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @inheritDoc
	 */
	public function setValue( $value ): FieldTypeInterface {
		$this->value = $value;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function isRequired(): bool {
		return $this->required;
	}

	/**
	 * @inheritDoc
	 */
	public function setRequired( bool $required = true ): FieldTypeInterface {
		$this->required = $required;
		return $this;
	}

}