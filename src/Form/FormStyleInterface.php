<?php

namespace Wpx\Form;

interface FormStyleInterface {

	/**
	 * Render an entire form.
	 *
	 * @param FormInterface $form
	 *
	 * @return string
	 */
	public function renderForm( FormInterface $form ): string;

	/**
	 * @param FormInterface $form
	 * @param FieldInterface $field
	 *
	 * @return string
	 */
	public function renderField( FormInterface $form, FieldInterface $field ): string;

	/**
	 * @param FormInterface $form
	 *
	 * @return string
	 */
	public function renderFormOpen( FormInterface $form ): string;

	/**
	 * @return string
	 */
	public function renderFormClose(): string;

}
