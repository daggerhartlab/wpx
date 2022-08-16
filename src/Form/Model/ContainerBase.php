<?php

namespace Wpx\Form\Model;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Collection\ElementsCollection;
use Wpx\Form\Collection\ElementsCollectionInterface;
use Wpx\Form\Collection\FieldsCollectionInterface;
use Wpx\Form\Service\EventsRegistryInterface;

class ContainerBase implements ContainerInterface {

	/**
	 * @var ElementInterface
	 */
	protected $element;

	/**
	 * @var string
	 */
	protected $type = '';

	/**
	 * @var string
	 */
	protected $name = '';

	/**
	 * @var string
	 */
	protected $id;

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
	 * Parent container item.
	 *
	 * @var ContainerInterface
	 */
	protected $parent;

	/**
	 * Child container items.
	 *
	 * @var FieldsCollectionInterface
	 */
	protected $children;

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
	public function __construct( ElementInterface $element, string $name = '', string $label = '' ) {
		$this
			->setElement( $element )
			->setDescriptors( new ElementsCollection() )
			->setName( $name )
			->setLabel( $label );
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
	public function getParent(): ContainerInterface {
		return $this->parent;
	}

	/**
	 * @inheritDoc
	 */
	public function setParent( ContainerInterface $parent ) {
		$this->parent = $parent;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getId(): string {
		return $this->id ??
			$this->id = $this->makeId();
	}

	/**
	 * @inheritDoc
	 */
	public function setId(string $id) {
		$this->id = $id;
		$this->getElement()
		     ->getAttributes()
		     ->set('id', $id);

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
	public function setType( string $type ) {
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
	public function setName( string $name ) {
		$this->name = $name;
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
	public function getLabel(): ElementInterface {
		return $this->getDescriptor('label');
	}

	/**
	 * @inheritDoc
	 */
	public function setLabel( string $label ) {
		$this->getLabel()->setContent( $label );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescription(): ElementInterface {
		return $this->getDescriptor('description');
	}

	/**
	 * @inheritDoc
	 */
	public function setDescription( string $description ) {
		$this->getDescription()->setContent( $description );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getHelpText(): ElementInterface {
		return $this->getDescriptor('help');
	}

	/**
	 * @inheritDoc
	 */
	public function setHelpText( string $help ) {
		$this->getHelpText()->setContent( $help );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getEventRegistry(): EventsRegistryInterface {
		return $this->eventsRegistry;
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
	public function getAttributes(): Attributes {
		return $this
			->getElement()
			->getAttributes();
	}

	/**
	 * @inheritDoc
	 */
	public function setAttributes( Attributes $attributes ) {
		$this->getElement()
		     ->setAttributes($attributes);

		return $this;
	}


	/**
	 * @inheritDoc
	 */
	public function getChildren(): FieldsCollectionInterface {
		return $this->children;
	}

	/**
	 * @inheritDoc
	 */
	public function setChildren( FieldsCollectionInterface $children ) {
		$this->children = $children->map( function( $field ) {
			return $field->setParent( $this );
		} );

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function addChild( ContainerInterface $child ) {
		$child->setParent( $this );
		$this->children->set( $child->getName(), $child );
		return $this;
	}

	/**
	 * Make a unique HTML id attribute for the field.
	 *
	 * @return string
	 */
	protected function makeId(): string {
		// @todo - remove WP specific sanitize_title.
		return implode( '--', array_map('sanitize_title', [
			$this->getParent()->getId(),
			$this->getName(),
		] ) );
	}
}
