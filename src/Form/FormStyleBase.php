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

			// @todo - refactor these things to a new type of thing.
			if ($field->getLabelPosition() === FieldInterface::POSITION_BEFORE_FIELD) {
				$output.= $this->renderFieldLabel( $field );
			}
			if ($field->getDescriptionPosition() === FieldInterface::POSITION_BEFORE_FIELD) {
				$output.= $this->renderFieldDescription( $field );
			}
			if ($field->getHelpPosition() === FieldInterface::POSITION_BEFORE_FIELD) {
				$output.= $this->renderFieldHelp( $field );
			}

			// Render the field html.
			$output.= $this->renderField( $field );

			// @todo - refactor these things to a new type of thing.
			if ($field->getLabelPosition() === FieldInterface::POSITION_AFTER_FIELD) {
				$output.= $this->renderFieldLabel( $field );
			}
			if ($field->getDescriptionPosition() === FieldInterface::POSITION_AFTER_FIELD) {
				$output.= $this->renderFieldDescription( $field );
			}
			if ($field->getHelpPosition() === FieldInterface::POSITION_AFTER_FIELD) {
				$output.= $this->renderFieldHelp( $field );
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
		$field->getAttributes()
		    ->set( 'type', $field->getType() )
			->set( 'id', $field->getId() )
			->set( 'name', $form->getId() . '[' . $field->getName() . ']' )
			->set( 'value', $field->getValue() ?? '' );

		$field = \apply_filters( 'wpx.form/pre_render_field', $field );
		$field = \apply_filters( "wpx.form/pre_render_field/type={$field->getType()}", $field );
		$field = \apply_filters( "wpx.form/pre_render_field/name={$field->getName()}", $field );
		$field->setAttributes( new Attributes( $field->getAttributes()->filter()->all() ) );
		$field->setLabelAttributes( new Attributes( $field->getLabelAttributes()->filter()->all() ) );

		return $field;
	}

	/**
	 * @inheritDoc
	 */
	public function renderField( FieldInterface $field ): string {
		return "<{$field->getElement()} {$field->getAttributes()->render()}>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldLabel( FieldInterface $field ): string {
		if ( empty( $field->getLabel() ) ) {
			return '';
		}

		return "<label for='{$field->getId()}' {$field->getLabelAttributes()->render()}>{$field->getLabel()}</label>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldDescription( FieldInterface $field ): string {
		if ( empty( $field->getDescription() ) ) {
			return '';
		}

		return "<div class='description'>{$field->getDescription()}</div>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldHelp( FieldInterface $field ): string {
		if ( empty( $field->getHelp() ) ) {
			return '';
		}

		return "<div class='help'>{$field->getHelp()}</div>";
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
