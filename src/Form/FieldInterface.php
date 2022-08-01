<?php

namespace Wpx\Form;

use DaggerhartLab\Collections\Map\MapInterface;

interface FieldInterface {

	/**
	 * Field HTML Element, if relevant.
	 *
	 * @return string
	 */
	public function getElement(): string;

	/**
	 * Field type.
	 *
	 * @return string
	 */
	public function getType(): string;

	/**
	 * Field machine name.
	 *
	 * @return string
	 */
	public function getName(): string;

	/**
	 * Field label.
	 *
	 * @return string
	 */
	public function getLabel(): string;

	/**
	 * Other field attributes.
	 *
	 * @return Attributes
	 */
	public function getAttributes(): Attributes;

	/**
	 * Field value.
	 *
	 * @return mixed
	 */
	public function getValue();

}
