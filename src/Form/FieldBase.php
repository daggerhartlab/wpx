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
	 * @var ElementsCollection
	 */
	protected $fieldDescriptors;

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
			->setFieldDescriptors( new ElementsCollection() )
			->setType( $type )
			->setName( $name )
			->setLabel( $label )
			->setAttributes( new Attributes( $attributes ) );
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
	public function getFieldDescriptors(): ElementsCollection {
		return $this->fieldDescriptors;
	}

	/**
	 * @inheritDoc
	 */
	public function setFieldDescriptors( ElementsCollection $fieldDescriptors ): FieldInterface {
		$this->fieldDescriptors = $fieldDescriptors;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFieldDescriptor( string $name ): ElementInterface {
		return $this->getFieldDescriptors()->get( $name ) ??
		       // Not found? Make an empty one and return it.
		       $this->getFieldDescriptors()
		            ->set( $name, new Element() )
		            ->get( $name );
	}

	/**
	 * @inheritDoc
	 */
	public function setFieldDescriptor( string $name, ElementInterface $descriptor ): FieldInterface {
		$this->getFieldDescriptors()->set( $name, $descriptor );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getLabel(): ElementInterface {
		return $this->getFieldDescriptor('label');
	}

	/**
	 * @inheritDoc
	 */
	public function setLabel( string $label ): FieldInterface {
		$this->getLabel()->setContent ($label );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescription(): ElementInterface {
		return $this->getFieldDescriptor('description');
	}

	/**
	 * @inheritDoc
	 */
	public function setDescription( string $description ): FieldInterface {
		$this->getDescription()->setContent( $description );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getHelp(): ElementInterface {
		return $this->getFieldDescriptor('help');
	}

	/**
	 * @inheritDoc
	 */
	public function setHelp( string $help ): FieldInterface {
		$this->getHelp()->setContent( $help );
		return $this;
	}

}
