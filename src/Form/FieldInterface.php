<?php

namespace Wpx\Form;

interface FieldInterface {

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
	 * @return FieldInterface
	 */
	public function setElement( ElementInterface $element ): FieldInterface;

	/**
	 * @return string
	 */
	public function getId(): string;

	/**
	 * @param string $id
	 *
	 * @return FieldInterface
	 */
	public function setId(string $id): FieldInterface;

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
	 * @return FieldInterface
	 */
	public function setType( string $type ): FieldInterface;

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
	 * @return FieldInterface
	 */
	public function setName( string $name ): FieldInterface;

	/**
	 * Field value.
	 *
	 * @return mixed
	 */
	public function getValue();

	/**
	 * Set the field value.
	 *
	 * @param mixed $value
	 *
	 * @return FieldBase
	 */
	public function setValue( $value ): FieldInterface;

	/**
	 * Get descriptors collection.
	 *
	 * @return ElementsCollection|ElementInterface[]
	 */
	public function getFieldDescriptors(): ElementsCollection;

	/**
	 * Set the descriptors collection.
	 *
	 * @param ElementsCollection $descriptors
	 *
	 * @return FieldInterface
	 */
	public function setFieldDescriptors( ElementsCollection $descriptors ): FieldInterface;

	/**
	 * Get descriptor by name.
	 *
	 * @param string $name
	 *
	 * @return ElementInterface
	 */
	public function getFieldDescriptor( string $name ): ElementInterface;

	/**
	 * Set the descriptor collection.
	 *
	 * @param string $name
	 * @param ElementInterface $descriptor
	 *
	 * @return FieldInterface
	 */
	public function setFieldDescriptor( string $name, ElementInterface $descriptor ): FieldInterface;

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
	 * @return FieldInterface
	 */
	public function setLabel(string $label): FieldInterface;

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
	 * @return FieldInterface
	 */
	public function setDescription( string $description ): FieldInterface;

	/**
	 * Get help text descriptor element.
	 *
	 * @return ElementInterface
	 */
	public function getHelp(): ElementInterface;

	/**
	 * Set help text.
	 *
	 * @param string $help
	 *
	 * @return FieldInterface
	 */
	public function setHelp(string $help): FieldInterface;

}
