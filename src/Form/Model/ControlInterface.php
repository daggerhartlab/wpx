<?php

namespace Wpx\Form\Model;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Collection\ElementsCollectionInterface;
use Wpx\Form\Collection\FieldsCollectionInterface;
use Wpx\Form\Service\EventsRegistryInterface;

interface ControlInterface {

	/**
	 * Field HTML Element, if relevant.
	 *
	 * @return ElementInterface
	 */
	public function getElement(): ElementInterface;

	/**
	 * Set the field html element.
	 *
	 * @param ElementInterface $element
	 *
	 * @return static
	 */
	public function setElement( ElementInterface $element );

	/**
	 * @return string
	 */
	public function getId(): string;

	/**
	 * @param string $id
	 *
	 * @return static
	 */
	public function setId(string $id);

	/**
	 * Field type.
	 *
	 * @return string
	 */
	public function getType(): string;

	/**
	 * Set the field type.
	 *
	 * @param string $type
	 *
	 * @return static
	 */
	public function setType( string $type );

	/**
	 * Field machine name.
	 *
	 * @return string
	 */
	public function getName(): string;

	/**
	 * Set the field name.
	 *
	 * @param string $name
	 *
	 * @return static
	 */
	public function setName( string $name );

	/**
	 * Get descriptors collection.
	 *
	 * @return ElementsCollectionInterface
	 */
	public function getDescriptors(): ElementsCollectionInterface;

	/**
	 * Set the descriptors collection.
	 *
	 * @param ElementsCollectionInterface $descriptors
	 *
	 * @return static
	 */
	public function setDescriptors( ElementsCollectionInterface $descriptors );

	/**
	 * Get descriptor by name.
	 *
	 * @param string $name
	 *
	 * @return ElementInterface
	 */
	public function getDescriptor( string $name ): ElementInterface;

	/**
	 * Set the descriptor collection.
	 *
	 * @param string $name
	 * @param ElementInterface $descriptor
	 *
	 * @return static
	 */
	public function setDescriptor( string $name, ElementInterface $descriptor );

	/**
	 * Get label descriptor element.
	 *
	 * @return ElementInterface
	 */
	public function getLabel(): ElementInterface;

	/**
	 * Set the field label.
	 *
	 * @param string $label
	 *
	 * @return static
	 */
	public function setLabel(string $label);

	/**
	 * Get description descriptor element.
	 *
	 * @return ElementInterface
	 */
	public function getDescription(): ElementInterface;

	/**
	 * Set field description text.
	 *
	 * @param string $description
	 *
	 * @return static
	 */
	public function setDescription( string $description );

	/**
	 * Get help text descriptor element.
	 *
	 * @return ElementInterface
	 */
	public function getHelpText(): ElementInterface;

	/**
	 * Set help text.
	 *
	 * @param string $help
	 *
	 * @return static
	 */
	public function setHelpText(string $help);

	/**
	 * @return EventsRegistryInterface
	 */
	public function getEventRegistry(): EventsRegistryInterface;

	/**
	 * @param EventsRegistryInterface $events_registry
	 *
	 * @return static
	 */
	public function setEventRegistry( EventsRegistryInterface $events_registry );

	/**
	 * Collection of other container element attributes.
	 *
	 * @return Attributes
	 */
	public function getAttributes(): Attributes;

	/**
	 * @param Attributes $attributes
	 *
	 * @return static
	 */
	public function setAttributes( Attributes $attributes );

	/**
	 * @return ControlInterface
	 */
	public function getParent(): ControlInterface;

	/**
	 * @param ControlInterface $parent
	 *
	 * @return static
	 */
	public function setParent( ControlInterface $parent );

	/**
	 * @return bool
	 */
	public function hasChildren(): bool;

	/**
	 * Get all fields on the form.
	 *
	 * @return FieldsCollectionInterface
	 */
	public function getChildren(): FieldsCollectionInterface;

	/**
	 * Set the entire fields map.
	 *
	 * @param FieldsCollectionInterface $children
	 *
	 * @return static
	 */
	public function setChildren( FieldsCollectionInterface $children );

	/**
	 * Add a field instance to the form.
	 *
	 * @param ControlInterface|FieldInterface $child
	 *
	 * @return static
	 */
	public function addChild( ControlInterface $child );
}
