<?php

namespace Wpx\Form\Model;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Collection\ElementsCollection;
use Wpx\Form\Collection\ElementsCollectionInterface;
use Wpx\Form\Collection\ContainersCollection;
use Wpx\Form\Collection\ContainersCollectionInterface;
use Wpx\Form\Service\EventsRegistry;
use Wpx\Form\Service\EventsRegistryInterface;

class ControlBase implements ControlInterface {

	/**
	 * @var string
	 */
	protected $name = '';

	/**
	 * @var ElementInterface
	 */
	protected $element;

	/**
	 * Additional content around a field. Ex: label, description, help text, etc.
	 *
	 * @var ElementsCollectionInterface
	 */
	protected $descriptors;

	/**
	 * Events registered to this container.
	 *
	 * @var EventsRegistryInterface
	 */
	protected $eventsRegistry;

	/**
	 * @var ControlInterface
	 */
	protected $root;

	/**
	 * Parent container item.
	 *
	 * @var ControlInterface
	 */
	protected $parent;

	/**
	 * Child container items.
	 *
	 * @var ContainersCollectionInterface
	 */
	protected $children;

	/**
	 * @var array
	 */
	protected $defaultValues = [];

	/**
	 * Create a new container.
	 *
	 * @param ElementInterface $element
	 *   Element for the container.
	 * @param string $name
	 *   Container machine name.
	 * @param string $label
	 *   Container label.
	 */
	public function __construct( ElementInterface $element, string $name, string $label = '' ) {
		$this
			->setElement( $element )
			->setDescriptors( new ElementsCollection() )
			->setName( $name )
			->setLabel( $label );
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
	public function setName( string $name ) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getElement(): ElementInterface {
		return $this->element;
	}

	/**
	 * @inheritDoc
	 */
	public function setElement( ElementInterface $element ) {
		$this->element = $element;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getElementTag(): string {
		return $this->getElement()->getTag();
	}

	/**
	 * @inheritDoc
	 */
	public function setElementTag( string $tag ) {
		$this->getElement()->setTag( $tag );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getElementAttributes(): Attributes {
		return $this
			->getElement()
			->getAttributes();
	}

	/**
	 * @inheritDoc
	 */
	public function setElementAttributes( Attributes $attributes ) {
		$this->getElement()
		     ->setAttributes($attributes);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getElementAttribute( string $name, $default = null ) {
		return $this->getElement()->getAttributes()->get( $name, $default );
	}

	/**
	 * @inheritDoc
	 */
	public function setElementAttribute( string $name, $value = null ) {
		$this->getElement()->getAttributes()->set( $name, $value );
		return $this;
	}


	/**
	 * @inheritDoc
	 */
	public function getElementId(): string {
		// If there is no ID, make one.
		return $this->getElementAttribute( 'id' ) ??
		       $this
			       ->setElementId( $this->makeId() )
			       ->getElementId();
	}

	/**
	 * @inheritDoc
	 */
	public function setElementId(string $id) {
		$this->setElementAttribute( 'id', $id );

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @inheritDoc
	 */
	public function setParent( ControlInterface $parent ) {
		$this->parent = $parent;
		$this->setRoot( $parent->getRoot() );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescriptors(): ElementsCollectionInterface {
		return $this->descriptors;
	}

	/**
	 * @inheritDoc
	 */
	public function setDescriptors( ElementsCollectionInterface $descriptors ) {
		$this->descriptors = $descriptors;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescriptor( string $name ): ElementInterface {
		return $this->getDescriptors()->get( $name ) ??
		       // Not found? Make an empty one and return it.
		       $this->getDescriptors()
		            ->set( $name, new Element() )
		            ->get( $name );
	}

	/**
	 * @inheritDoc
	 */
	public function setDescriptor( string $name, ElementInterface $descriptor ) {
		$this->getDescriptors()->set( $name, $descriptor );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getLabelElement(): ElementInterface {
		return $this->getDescriptor('label');
	}

	/**
	 * @inheritDoc
	 */
	public function setLabel( string $label ) {
		$this
			->getLabelElement()
			->setContent( $label );

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescriptionElement(): ElementInterface {
		return $this->getDescriptor('description');
	}

	/**
	 * @inheritDoc
	 */
	public function setDescription( string $description ) {
		$this
			->getDescriptionElement()
			->setContent( $description );

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getHelpTextElement(): ElementInterface {
		return $this->getDescriptor('help');
	}

	/**
	 * @inheritDoc
	 */
	public function setHelpText( string $help ) {
		$this->getHelpTextElement()->setContent( $help );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getEventRegistry(): EventsRegistryInterface {
		return $this->eventsRegistry ??
			$this
				->setEventRegistry( new EventsRegistry() )
				->getEventRegistry();
	}

	/**
	 * @inheritDoc
	 */
	public function setEventRegistry( EventsRegistryInterface $events_registry ) {
		$this->eventsRegistry = $events_registry;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function isRoot(): bool {
		return is_null( $this->getParent() );
	}

	/**
	 * @inheritDoc
	 */
	public function getRoot(): ControlInterface {
		return $this->isRoot() ? $this : $this->root;
	}

	/**
	 * @inheritDoc
	 */
	public function setRoot( ControlInterface $control ) {
		$this->root = $control;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function hasChildren(): bool {
		return !$this->getChildren()->isEmpty();
	}

	/**
	 * @inheritDoc
	 */
	public function getChildren(): ContainersCollectionInterface {
		return $this->children ??
			$this
				->setChildren( new ContainersCollection() )
				->getChildren();
	}

	/**
	 * @inheritDoc
	 */
	public function setChildren( ContainersCollectionInterface $children ) {
		$this->children = $children->map( function( $field ) {
			return $field->setParent( $this );
		} );

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function addChild( ControlInterface $child ) {
		$child->setParent( $this );
		$child->setRoot( $this->getRoot() );
		$this->children->set( $child->getName(), $child );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDefaultValues(): array {
		return $this->defaultValues;
	}

	/**
	 * @inheritDoc
	 */
	public function setDefaultValues( array $values ) {
		$this->defaultValues = $values;
		if ( $this->hasChildren() ) {
			$this->applyDefaultValues( $this->getChildren(), $values );
		}

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function applyDefaultValues( ContainersCollectionInterface $children, array $default_values = [] ) {
		foreach ($children as $child) {
			if ( !array_key_exists( $child->getName(), $default_values ) ) {
				continue;
			}

			$child_value = $default_values[ $child->getName() ];
			if ( $child instanceof FieldTypeInterface ) {
				$child->setValue( $child_value );
			}

			if ( $child->hasChildren() && is_array( $child_value ) ) {
				$this->applyDefaultValues( $child->getChildren(), $child_value);
			}
		}
		return $this;
	}

	/**
	 * Make a unique HTML id attribute for the field.
	 *
	 * @return string
	 */
	protected function makeId(): string {
		$parts = [];
		if ( $this->getParent() ) {
			$parts[] = $this->getParent()->getElementId();
		}
		$parts[] = $this->getName();

		// @todo - remove WP specific sanitize_title.
		return implode( '--', array_map('sanitize_title', $parts ) );
	}
}
