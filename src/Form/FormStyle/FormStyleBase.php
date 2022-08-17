<?php

namespace Wpx\Form\FormStyle;

use Wpx\Form\Model\ControlInterface;
use Wpx\Form\Model\ElementInterface;
use Wpx\Form\Model\FieldTypeInterface;
use Wpx\Form\Model\FormInterface;

/**
 * Form style handles the rendering of the form and fields.
 */
abstract class FormStyleBase implements FormStyleInterface {

	/**
	 * @inheritDoc
	 */
	public function renderFormTemplate( FormInterface $form, string $inner_html ): string {
		$form->getElement()->setContent( $inner_html );
		return $this->renderElementTemplate( $form->getElement() );
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
	public function renderFieldWrapperTemplate( FieldTypeInterface $field, array $context = [] ): string {
		return "
		<div class='field-wrapper field-type--{$field->getElementTag()} field-id--{$field->getElementId()}'>
			{$context['before_field']}
			{$context['field_html']}{$context['after_field']}
		</div>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldTemplate( FieldTypeInterface $field ): string {
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
		if ( $element->isVoidElement() ) {
			return "<{$element->getTag()} {$element->getAttributes()->render()}>";
		}

		return "<{$element->getTag()} {$element->getAttributes()->render()}>{$element->getContent()}</{$element->getTag()}>";
	}

}
