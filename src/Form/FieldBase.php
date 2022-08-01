<?php

namespace Wpx\Form;

class FieldBase implements FieldInterface {

	/**
	 * @var string
	 */
	protected $element = 'input';

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var Attributes
	 */
	protected $attributes;

	/**
	 * @var mixed
	 */
	protected $value;

	public function __construct() {}

	/**
	 * @inheritDoc
	 */
	public function getElement(): string {
		return $this->element;
	}

	/**
	 * Set the field html element.
	 *
	 * @param string $element
	 *
	 * @return FieldInterface
	 */
	public function setElement(string $element): FieldInterface {
		$this->element = $element;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string {
		return $this->label;
	}

	/**
	 * @param string $label
	 *
	 * @return FieldInterface
	 */
	public function setLabel(string $label): FieldInterface {
		$this->label = $label;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @param string $type
	 *
	 * @return FieldInterface
	 */
	public function setType( string $type ): FieldInterface {
		$this->type = $type;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return FieldInterface
	 */
	public function setName( string $name ): FieldInterface {
		$this->name = $name;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getAttributes(): Attributes {
		return $this->attributes;
	}

	/**
	 * @param Attributes $attributes
	 *
	 * @return FieldInterface
	 */
	public function setAttributes( Attributes $attributes ): FieldInterface {
		$this->attributes = $attributes;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param mixed $value
	 *
	 * @return FieldBase
	 */
	public function setValue( $value ) {
		$this->value = $value;

		return $this;
	}

}
