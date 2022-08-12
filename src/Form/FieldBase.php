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
	 * @var Attributes
	 */
	protected $labelAttributes;

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * Create a new field.
	 *
	 * @param string $name
	 *   Field machine name.
	 * @param array $attributes
	 *   Array of field attributes.
	 */
	public function __construct( string $name, array $attributes = [] ) {
		$this->setName( $name );
		$this->setAttributes( new Attributes( $attributes ) );
		$this->setLabelAttributes( new Attributes( [] ) );
	}

	/**
	 * @inheritDoc
	 */
	public function getElement(): string {
		return $this->element;
	}

	/**
	 * @inheritDoc
	 */
	public function setElement(string $element): FieldInterface {
		$this->element = $element;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @inheritDoc
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
	 * @inheritDoc
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
	 * @inheritDoc
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
	 * @inheritDoc
	 */
	public function setValue( $value ): FieldInterface {
		$this->value = $value;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string {
		return $this->label;
	}

	/**
	 * @inheritDoc
	 */
	public function setLabel(string $label): FieldInterface {
		$this->label = $label;
		return $this;
	}
	/**
	 * @inheritDoc
	 */
	public function getLabelAttributes(): Attributes {
		return $this->labelAttributes;
	}

	/**
	 * @inheritDoc
	 */
	public function setLabelAttributes( Attributes $attributes ): FieldInterface {
		$this->labelAttributes = $attributes;

		return $this;
	}

}
