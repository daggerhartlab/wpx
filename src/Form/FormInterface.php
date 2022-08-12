<?php

namespace Wpx\Form;

use DaggerhartLab\Collections\Map\MapInterface;
use Wpx\Form\Collection\FieldsCollection;
use Wpx\Form\FormStyle\FormStyleInterface;

interface FormInterface {

	/**
	 * Unique form id.
	 *
	 * @return string
	 */
	public function getId(): string;

	/**
	 * Set the unique form id.
	 *
	 * @param string $id
	 *
	 * @return FormInterface
	 */
	public function setId(string $id): FormInterface;

	/**
	 * Form submit method.
	 *
	 * @return string
	 */
	public function getMethod(): string;

	/**
	 * Set the form method attribute.
	 *
	 * @param string $method
	 *
	 * @return FormInterface
	 */
	public function setMethod( string $method ): FormInterface;

	/**
	 * Form action attribute (url|uri).
	 *
	 * @return string
	 */
	public function getAction(): string;

	/**
	 * Set the action attribute for the form.
	 *
	 * @param string $action
	 *
	 * @return self
	 */
	public function setAction( string $action ): FormInterface;

	/**
	 * Form style.
	 *
	 * @return FormStyleInterface
	 */
	public function getFormStyle(): FormStyleInterface;

	/**
	 * Set the form style object.
	 *
	 * @param FormStyleInterface $style
	 *
	 * @return FormBase
	 */
	public function setFormStyle( FormStyleInterface $style ): FormInterface;

	/**
	 * Collection of other form element attributes.
	 *
	 * @return Attributes
	 */
	public function getAttributes(): Attributes;

	/**
	 * @param Attributes $attributes
	 *
	 * @return FormBase
	 */
	public function setAttributes( Attributes $attributes ): FormInterface;

	/**
	 * Render the form into HTML.
	 *
	 * @return string
	 */
	public function render(): string;

	/**
	 * Get all fields on the form.
	 *
	 * @return FieldsCollection
	 */
	public function getFields(): FieldsCollection;

	/**
	 * Set the entire fields map.
	 *
	 * @param FieldsCollection $fields
	 *
	 * @return FormInterface
	 */
	public function setFields( FieldsCollection $fields ): FormInterface;

	/**
	 * Add a field instance to the form.
	 *
	 * @param FieldInterface $field
	 *
	 * @return FormInterface
	 */
	public function addField(FieldInterface $field): FormInterface;

	/**
	 * Get all values submitted by the form.
	 *
	 * @return MapInterface
	 */
	public function getSubmittedValues(): MapInterface;

}
