<?php

namespace Wpx\Form;

interface FieldInterface {

	/*
	 * For relative positioning of sub-elements of a field.
	 */
	const POSITION_HIDDEN = 0;
	const POSITION_BEFORE_FIELD = 1;
	const POSITION_AFTER_FIELD = 2;

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

	/**
	 * Get label relative position.
	 *
	 * @return int
	 */
	public function getLabelPosition(): int;

	/**
	 * Set label relative position.
	 *
	 * @param int $position
	 *
	 * @return FieldInterface
	 */
	public function setLabelPosition(int $position): FieldInterface;

	/**
	 * Get description text.
	 *
	 * @return string
	 */
	public function getDescription(): string;

	/**
	 * Set field description text.
	 *
	 * @param string $description
	 *
	 * @return FieldInterface
	 */
	public function setDescription( string $description ): FieldInterface;

	/**
	 * Get description relative position.
	 *
	 * @return int
	 */
	public function getDescriptionPosition(): int;

	/**
	 * Set description relative position.
	 *
	 * @param int $position
	 *
	 * @return FieldInterface
	 */
	public function setDescriptionPosition(int $position): FieldInterface;

	/**
	 * Get help text.
	 *
	 * @return string
	 */
	public function getHelp(): string;

	/**
	 * Set help text.
	 *
	 * @param string $help
	 *
	 * @return FieldInterface
	 */
	public function setHelp(string $help): FieldInterface;

	/**
	 * Get help text relative position.
	 *
	 * @return int
	 */
	public function getHelpPosition(): int;

	/**
	 * Set help text relative position.
	 *
	 * @param int $position
	 *
	 * @return FieldInterface
	 */
	public function setHelpPosition(int $position);

}
