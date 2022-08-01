<?php

namespace Wpx\Form;

use DaggerhartLab\Collections\Map\MapInterface;

interface FormInterface {

	/**
	 * Unique form id.
	 *
	 * @return string
	 */
	public function getFormId(): string;

	/**
	 * Form submit method.
	 *
	 * @return string
	 */
	public function getFormMethod(): string;

	/**
	 * Form action attribute (url|uri).
	 *
	 * @return string
	 */
	public function getFormAction(): string;

	/**
	 * Form style.
	 *
	 * @return FormStyleInterface
	 */
	public function getFormStyle(): FormStyleInterface;

	/**
	 * Collection of other form element attributes.
	 *
	 * @return Attributes
	 */
	public function getFormAttributes(): Attributes;

	/**
	 * Render the form into HTML.
	 *
	 * @return string
	 */
	public function render(): string;

	/**
	 * Add a field instance to the form.
	 *
	 * @param FieldInterface $field
	 *
	 * @return FormInterface
	 */
	public function addField(FieldInterface $field): FormInterface;

	/**
	 * Get all fields on the form.
	 *
	 * @return MapInterface
	 */
	public function getFields(): MapInterface;

	/**
	 * Get all values submitted by the form.
	 *
	 * @return MapInterface
	 */
	public function getSubmittedValues(): MapInterface;

}
