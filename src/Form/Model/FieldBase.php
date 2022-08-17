<?php

namespace Wpx\Form\Model;

abstract class FieldBase extends ControlBase implements FieldInterface {

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
	public function setValue( $value ): FieldInterface {
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
	public function setRequired( bool $required = true ): FieldInterface {
		$this->required = $required;
		return $this;
	}

}
