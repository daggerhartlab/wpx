<?php

namespace Wpx\Form\Model;

interface FieldInterface extends ControlInterface {

	/**
	 * @return string
	 */
	public static function getDefaultElementTag(): string;

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
	 * @return FieldInterface
	 */
	public function setValue( $value ): FieldInterface;

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
	 * @return FieldInterface
	 */
	public function setRequired( bool $required = true ): FieldInterface;

}
