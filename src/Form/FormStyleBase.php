<?php

namespace Wpx\Form;

/**
 * Form style handles the rendering of the form and fields.
 */
class FormStyleBase implements FormStyleInterface {

	/**
	 * @inheritDoc
	 */
	public function preRenderForm( FormInterface $form ): FormInterface {
		$form->getAttributes()
		     ->set('id', $form->getId() )
		     ->set('method', $form->getMethod() )
		     ->set('action', $form->getAction() );

		$form = \apply_filters( 'wpx.form/pre_render_form', $form );
		$form = \apply_filters( "wpx.form/pre_render_form/id={$form->getId()}", $form );
		$form->setAttributes( new Attributes( $form->getAttributes()->filter()->all() ) );

		return $form;
	}

	/**
	 * @inheritDoc
	 */
	public function renderForm( FormInterface $form ): string {
		$this->preRenderForm( $form );
		$output = $this->renderFormOpen( $form );

		foreach ($form->getFields() as $field) {
			// Prepare the object.
			$field = $this->preRenderField( $field, $form );

			// Start the html for this field.
			$output.= $this->renderFieldWrapperOpen( $field );

			// Before the field.
			foreach ( $field->getFieldDescriptors() as $element ) {
				if ( $element->getPosition() === ElementInterface::POSITION_BEFORE_FIELD ) {
					$output.= $this->renderElement( $element );
				}
			}

			// Render the field html.
			$output.= $this->renderField( $field );

			// After the field.
			foreach ( $field->getFieldDescriptors() as $element ) {
				if ( $element->getPosition() === ElementInterface::POSITION_AFTER_FIELD ) {
					$output.= $this->renderElement( $element );
				}
			}

			// Close the field wrapper.
			$output.= $this->renderFieldWrapperClose( $field );
		}

		$output.= $this->renderFormClose();
		return $output;
	}

	/**
	 * @inheritDoc
	 */
	public function renderFormOpen( FormInterface $form ): string {
		return "<form {$form->getAttributes()->render()}>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFormClose(): string {
		return "</form>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldWrapperOpen( FieldInterface $field ): string {
		return "<div class='field-wrapper field-type--{$field->getType()} field-id--{$field->getId()}'>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldWrapperClose( FieldInterface $field ): string {
		return '</div>';
	}

	/**
	 * @inheritDoc
	 */
	public function preRenderField( FieldInterface $field, FormInterface $form ) {
		$field->setId( $this->makeFieldId( $form, $field ) );
		$field->getElement()->getAttributes()
		    ->set( 'type', $field->getType() )
			->set( 'id', $field->getId() )
			->set( 'name', $form->getId() . '[' . $field->getName() . ']' )
			->set( 'value', $field->getValue() ?? '' );

		$field = \apply_filters( 'wpx.form/pre_render_field', $field );
		$field = \apply_filters( "wpx.form/pre_render_field/type={$field->getType()}", $field );
		/** @var FieldInterface $field */
		$field = \apply_filters( "wpx.form/pre_render_field/name={$field->getName()}", $field );
		$field->getElement()->setAttributes( new Attributes( $field->getElement()->getAttributes()->filter()->all() ) );

		// Prepare the descriptors.
		$field->getLabel()
			->setTag('label')
			->getAttributes()
				->set('for', $this->makeFieldId( $form, $field ) );

		// Hide empty descriptors.
		foreach ( $field->getFieldDescriptors() as $element ) {
			if ( empty( $element->getContent() ) ) {
				$element->setPosition( ElementInterface::POSITION_HIDDEN );
			}
		}

		// Sort descriptors.
		$field->setFieldDescriptors( $field->getFieldDescriptors()->sortedByOrder() );
		return $field;
	}

	/**
	 * @inheritDoc
	 */
	public function renderField( FieldInterface $field ): string {
		return "<{$field->getElement()->getTag()} {$field->getElement()->getAttributes()->render()}>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderElement( ElementInterface $element ): string {
		if ( empty( $element->getContent() ) ) {
			return '';
		}

		return "<{$element->getTag()} {$element->getAttributes()->render()}>{$element->getContent()}</{$element->getTag()}>";
	}

	/**
	 * @param FormInterface $form
	 * @param FieldInterface $field
	 *
	 * @return string
	 */
	protected function makeFieldId( FormInterface $form, FieldInterface $field ): string {
		return implode( '--', array_map('sanitize_title', [
			$form->getId(),
			$field->getName(),
		] ) );
	}

}
