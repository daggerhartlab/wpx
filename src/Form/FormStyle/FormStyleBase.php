<?php

namespace Wpx\Form\FormStyle;

use Wpx\Form\Model\ControlInterface;
use Wpx\Form\Model\ElementInterface;
use Wpx\Form\Model\FieldInterface;
use Wpx\Form\Model\FormInterface;

/**
 * Form style handles the rendering of the form and fields.
 */
abstract class FormStyleBase implements FormStyleInterface {

	/**
	 * @inheritDoc
	 */
	public function renderFormTemplate( FormInterface $form, string $inner_html ): string {
		return "
		<form {$form->getAttributes()->render()}>
			{$inner_html}
		</form>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderControlTemplate( ControlInterface $control, string $inner_html ): string {
		$control->getElement()->setContent( $inner_html );
		return $this->renderElementTemplate( $control->getElement() );
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldWrapperTemplate( FieldInterface $field, string $field_html, array $descriptors = [] ): string {
		return "
		<div class='field-wrapper field-type--{$field->getType()} field-id--{$field->getId()}'>
			{$descriptors['before_field']}
			{$field_html}
			{$descriptors['after_field']}
		</div>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldTemplate( FieldInterface $field ): string {
		$element = $field->getElement();

		if ( $element->isVoidElement() ) {
			return "<{$element->getTag()} {$element->getAttributes()->render()}>";
		}

		return "<{$element->getTag()} {$element->getAttributes()->render()}>{$element->getContent()}</{$element->getTag()}>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderElementTemplate( ElementInterface $element ): string {
		// If this is a tag that expects content but is empty, render nothing.
		if ( $element->isEmpty() && !$element->isVoidElement() ) {
			return '';
		}

		if ( $element->isVoidElement() ) {
			return "<{$element->getTag()} {$element->getAttributes()->render()}>";
		}

		return "<{$element->getTag()} {$element->getAttributes()->render()}>{$element->getContent()}</{$element->getTag()}>";
	}

}
