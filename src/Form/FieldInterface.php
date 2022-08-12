<?php

namespace Wpx\Form;

interface FieldInterface {

	/**
	 * Field HTML Element, if relevant.
	 *
	 * @return string
	 */
	public function getElement(): string;

	/**
	 * Set the field html element.
	 *
	 * @param string $element
	 *
	 * @return FieldInterface
	 */
	public function setElement(string $element): FieldInterface;

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
	 * Field label.
	 *
	 * @return string
	 */
	public function getLabel(): string;

	/**
	 * Set the field label.
	 *
	 * @param string $label
	 *
	 * @return FieldInterface
	 */
	public function setLabel(string $label): FieldInterface;

	/**
	 * Get field element attributes.
	 *
	 * @return Attributes
	 */
	public function getAttributes(): Attributes;

	/**
	 * Set field element attributes.
	 *
	 * @param Attributes $attributes
	 *
	 * @return FieldInterface
	 */
	public function setAttributes( Attributes $attributes ): FieldInterface;

	/**
	 * Get field label attributes.
	 *
	 * @return Attributes
	 */
	public function getLabelAttributes(): Attributes;

	/**
	 * Set field label attributes.
	 *
	 * @param Attributes $attributes
	 *
	 * @return FieldInterface
	 */
	public function setLabelAttributes( Attributes $attributes ): FieldInterface;

}
