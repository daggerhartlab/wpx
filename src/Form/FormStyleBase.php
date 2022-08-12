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
			$field = $this->preRenderField( $field, $form );
			$output.= $this->renderFieldLabel( $field );
			$output.= $this->renderField( $field );
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
	public function preRenderField( FieldInterface $field, FormInterface $form ) {
		$field->getAttributes()
		    ->set( 'type', $field->getType() )
			->set( 'id', $this->makeFieldId( $form, $field ) )
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
		return "<label for='{$field->getAttributes()->get('id')}' {$field->getLabelAttributes()->render()}>{$field->getLabel()}</label>";
	}

	/**
	 * @param FormInterface $form
	 * @param FieldInterface $field
	 *
	 * @return string
	 */
	protected function makeFieldId( FormInterface $form, FieldInterface $field ): string {
		$id = \sanitize_title( $form->getId() . '-' . $field->getName() );
		return str_replace('-', '--', $id );
	}

}
