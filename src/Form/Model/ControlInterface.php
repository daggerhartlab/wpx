<?php

namespace Wpx\Form\Model;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Collection\ElementsCollectionInterface;
use Wpx\Form\Collection\ContainersCollectionInterface;
use Wpx\Form\Service\EventsRegistryInterface;

interface ControlInterface {

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
	 * Get the element html tag.
	 *
	 * @return string
	 */
	public function getElementTag(): string;

	/**
	 * Set the element html tag.
	 *
	 * @param string $tag
	 *
	 * @return static
	 */
	public function setElementTag( string $tag );

	/**
	 * Collection of other container element attributes.
	 *
	 * @return Attributes
	 */
	public function getElementAttributes(): Attributes;

	/**
	 * @param Attributes $attributes
	 *
	 * @return static
	 */
	public function setElementAttributes( Attributes $attributes );

	/**
	 * Get an element attribute value.
	 *
	 * @param string $name
	 * @param string|int|float|null $default
	 *
	 * @return string|int|float|null
	 */
	public function getElementAttribute( string $name, $default = null );

	/**
	 * Set an element attribute value.
	 *
	 * @param string $name
	 * @param string|int|float|null $value
	 *
	 * @return static
	 */
	public function setElementAttribute( string $name, $value = null );

	/**
	 * @return string
	 */
	public function getElementId(): string;

	/**
	 * @param string $id
	 *
	 * @return static
	 */
	public function setElementId(string $id);

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
	public function getLabelElement(): ElementInterface;

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
	public function getDescriptionElement(): ElementInterface;

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
	public function getHelpTextElement(): ElementInterface;

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
	 * @return ContainersCollectionInterface
	 */
	public function getChildren(): ContainersCollectionInterface;

	/**
	 * Set the entire fields map.
	 *
	 * @param ContainersCollectionInterface $children
	 *
	 * @return static
	 */
	public function setChildren( ContainersCollectionInterface $children );

	/**
	 * Add a field instance to the form.
	 *
	 * @param ControlInterface|FieldInterface $child
	 *
	 * @return static
	 */
	public function addChild( ControlInterface $child );

	/**
	 * Get stored default values for control and children.
	 *
	 * @return array
	 */
	public function getDefaultValues(): array;

	/**
	 * Set default values for control and children.
	 *
	 * @param array $values
	 *
	 * @return static
	 */
	public function setDefaultValues( array $values );

	/**
	 * Apply the default values recursively to children.
	 *
	 * @param ContainersCollectionInterface $children
	 * @param array $default_values
	 *
	 * @return static
	 */
	public function applyDefaultValues( ContainersCollectionInterface $children, array $default_values = [] );

}
