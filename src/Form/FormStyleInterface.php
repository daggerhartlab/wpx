<?php

namespace Wpx\Form;

interface FormStyleInterface {

	/**
	 * Adjust the form object immediately before rendering.
	 *
	 * @param FormInterface $form
	 *
	 * @return FormInterface
	 */
	public function preRenderForm( FormInterface $form ): FormInterface;

	/**
	 * Render an entire form.
	 *
	 * @param FormInterface $form
	 *
	 * @return string
	 */
	public function renderForm( FormInterface $form ): string;

	/**
	 * Open the form element.
	 *
	 * @param FormInterface $form
	 *
	 * @return string
	 */
	public function renderFormOpen( FormInterface $form ): string;

	/**
	 * Close the form element.
	 *
	 * @return string
	 */
	public function renderFormClose(): string;

	/**
	 * Open field wrapper element.
	 *
	 * @param FieldInterface $field
	 *
	 * @return string
	 */
	public function renderFieldWrapperOpen( FieldInterface $field ): string;

	/**
	 * Close field wrapper element.
	 *
	 * @param FieldInterface $field
	 *
	 * @return string
	 */
	public function renderFieldWrapperClose( FieldInterface $field ): string;

	/**
	 * Adjust the field object immediately before rendering.
	 *
	 * @param FieldInterface $field
	 * @param FormInterface $form
	 *
	 * @return mixed
	 */
	public function preRenderField( FieldInterface $field, FormInterface $form );

	/**
	 * Render the field object.
	 *
	 * @param FieldInterface $field
	 *
	 * @return string
	 */
	public function renderField( FieldInterface $field ): string;

	/**
	 * Render field description.
	 *
	 * @param ElementInterface $element
	 *
	 * @return string
	 */
	public function renderElement( ElementInterface $element ): string;

}
