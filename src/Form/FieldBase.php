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
	protected $id;

	/**
	 * @var string
	 */
	protected $label = '';

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $name = '';

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @var Attributes
	 */
	protected $attributes;

	/**
	 * @var Attributes
	 */
	protected $labelAttributes;

	/**
	 * @var int
	 */
	protected $labelPosition = FieldInterface::POSITION_BEFORE_FIELD;

	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * @var int
	 */
	protected $descriptionPosition = FieldInterface::POSITION_BEFORE_FIELD;

	/**
	 * @var string
	 */
	protected $help = '';

	/**
	 * @var int
	 */
	protected $helpPosition = FieldInterface::POSITION_AFTER_FIELD;

	/**
	 * Create a new field.
	 *
	 * @param string $type
	 *   Field type.
	 * @param string $name
	 *   Field machine name.
	 * @param string $label
	 *   Field label.
	 * @param array $attributes
	 *   Array of field attributes.
	 */
	public function __construct( string $type = 'text', string $name = '', string $label = '', array $attributes = [] ) {
		$this
			->setType( $type )
			->setName( $name )
			->setLabel( $label )
			->setAttributes( new Attributes( $attributes ) )
			->setLabelAttributes( new Attributes( [] ) );
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
	public function getId(): string {
		return $this->id;
	}

	/**
	 * @inheritDoc
	 */
	public function setId(string $id): FieldInterface {
		$this->id = $id;
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

	/**
	 * @inheritDoc
	 */
	public function getLabelPosition(): int {
		return $this->labelPosition;
	}

	/**
	 * @inheritDoc
	 */
	public function setLabelPosition( int $position ): FieldInterface {
		$this->labelPosition = $position;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescription(): string {
		return $this->description;
	}

	/**
	 * @inheritDoc
	 */
	public function setDescription( string $description ): FieldInterface {
		$this->description = $description;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescriptionPosition(): int {
		return $this->descriptionPosition;
	}

	/**
	 * @inheritDoc
	 */
	public function setDescriptionPosition( int $position ): FieldInterface {
		$this->descriptionPosition = $position;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getHelp(): string {
		return $this->help;
	}

	/**
	 * @inheritDoc
	 */
	public function setHelp( string $help ): FieldInterface {
		$this->help = $help;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getHelpPosition(): int {
		return $this->helpPosition;
	}

	/**
	 * @inheritDoc
	 */
	public function setHelpPosition( int $position ): FieldInterface {
		$this->helpPosition = $position;
		return $this;
	}

}
