<?php

namespace Wpx\Form\Model;

interface FieldTypeInterface extends ControlInterface {

	/**
	 * Get the field type unique id.
	 *
	 * @internal
	 *
	 * @return string
	 */
	public static function id(): string;

	/**
	 * Get the field type's default html element tag.
	 *
	 * @internal
	 *
	 * @return string
	 */
	public static function defaultElementTag(): string;

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
	 * @return FieldTypeInterface
	 */
	public function setValue( $value ): FieldTypeInterface;

	/**
	 * Whether the field is required.
	 *
	 * @return bool
	 */
	public function isRequired(): bool;

	/**
	 * Set the field to be required or not.
	 *
	 * @param bool $required
	 *
	 * @return FieldTypeInterface
	 */
	public function setRequired( bool $required = true ): FieldTypeInterface;

}
