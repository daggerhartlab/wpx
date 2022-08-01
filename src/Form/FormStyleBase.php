<?php

namespace Wpx\Form;

class FormStyleBase implements FormStyleInterface {

	/**
	 * @inheritDoc
	 */
	public function renderForm( FormInterface $form ): string {
		$output = $this->renderFormOpen( $form );
		foreach ($form->getFields() as $field) {
			$output.= $this->renderField( $form, $field );
		}
		$output.= $this->renderFormClose();
		return $output;
	}

	/**
	 * @inheritDoc
	 */
	public function renderField( FormInterface $form, FieldInterface $field ): string {
		$attributes = $field->getAttributes();
		$attributes
			->set('type', $field->getType())
			->set('name', $form->getFormId() . '[' . $field->getName() . ']' )
			->set('value', $field->getValue() ?? '' );
		$attributes = new Attributes( $attributes->filter()->all() );

		return "<{$field->getElement()} {$attributes->render()}>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFormOpen( FormInterface $form ): string {
		$attributes = $form->getFormAttributes();
		$attributes
			->set('id', $form->getFormId() )
			->set('method', $form->getFormMethod() )
			->set('action', $form->getFormAction() );
		$attributes = new Attributes( $attributes->filter()->all() );

		return "<form {$attributes->render()}>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFormClose(): string {
		return "</form>";
	}
}
