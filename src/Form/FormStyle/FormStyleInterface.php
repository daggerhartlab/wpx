<?php

namespace Wpx\Form\FormStyle;

use Wpx\Form\Model\ControlInterface;
use Wpx\Form\Model\ElementInterface;
use Wpx\Form\Model\FieldInterface;
use Wpx\Form\Model\FormInterface;

interface FormStyleInterface {

	/**
	 * Unique name for the form style.
	 *
	 * @return string
	 */
	public static function name(): string;

	/**
	 * @param FormInterface $form
	 * @param string $inner_html
	 *
	 * @return string
	 */
	public function renderFormTemplate( FormInterface $form, string $inner_html ): string;

	/**
	 * @param ControlInterface $control
	 * @param string $inner_html
	 *
	 * @return string
	 */
	public function renderControlTemplate( ControlInterface $control, string $inner_html ): string;

	/**
	 * @param FieldInterface $field
	 * @param string $field_html
	 * @param array $descriptors
	 *   Known: label, description, help, before_field, after_field.
	 *
	 * @return string
	 */
	public function renderFieldWrapperTemplate( FieldInterface $field, string $field_html, array $descriptors ): string;

	/**
	 * Render the field object.
	 *
	 * @param FieldInterface $field
	 *
	 * @return string
	 */
	public function renderFieldTemplate( FieldInterface $field ): string;

	/**
	 * Render field description.
	 *
	 * @param ElementInterface $element
	 *
	 * @return string
	 */
	public function renderElementTemplate( ElementInterface $element ): string;

}
