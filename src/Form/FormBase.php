<?php

namespace Wpx\Form;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Collection\FieldsCollection;
use Wpx\Form\Collection\SubmittedValues;
use Wpx\Form\Collection\SubmittedValuesInterface;
use Wpx\Form\FormStyle\FormStyleInterface;

class FormBase implements FormInterface {

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var ElementInterface
	 */
	protected $element;

	/**
	 * @var string
	 */
	protected $method = '';

	/**
	 * Route for the form.
	 *
	 * @var string
	 */
	protected $action = '';

	/**
	 * @var Attributes
	 */
	protected $attributes;

	/**
	 * @var FormStyleInterface
	 */
	protected $formStyle;

	/**
	 * @var FieldsCollection
	 */
	protected $fields;

	/**
	 * @inheritDoc
	 */
	public function getElement(): ElementInterface {
		if (empty($this->element)) {
			$this->element = (new Element())->setTag('form');
		}

		return $this->element;
	}

	/**
	 * @inheritDoc
	 */
	public function setElement( ElementInterface $element ): FormInterface {
		$this->element = $element;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getId(): string {
		return $this->id;
	}

	/**
	 * @inheritDoc
	 */
	public function setId(string $id): FormInterface {
		$this->id = $id;
		$this->getElement()
		     ->getAttributes()
		     ->set('id', $id);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getMethod(): string {
		return $this->method;
	}

	/**
	 * @inheritDoc
	 */
	public function setMethod( string $method ): FormInterface {
		$this->method = $method;
		$this->getElement()
		     ->getAttributes()
		     ->set('method', $method);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getAction(): string {
		return $this->action;
	}

	/**
	 * @inheritDoc
	 */
	public function setAction( string $action ): FormInterface {
		$this->action = $action;
		$this->getElement()
		     ->getAttributes()
		     ->set('action', $action);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getAttributes(): Attributes {
		return $this
			->getElement()
			->getAttributes();
	}

	/**
	 * @inheritDoc
	 */
	public function setAttributes( Attributes $attributes ): FormInterface {
		$this->getElement()
		     ->setAttributes($attributes);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFormStyle(): FormStyleInterface {
		return $this->formStyle;
	}

	/**
	 * @inheritDoc
	 */
	public function setFormStyle( FormStyleInterface $style ): FormInterface {
		$this->formStyle = $style;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFields(): FieldsCollection {
		return $this->fields;
	}

	/**
	 * @inheritDoc
	 */
	public function setFields( FieldsCollection $fields ): FormInterface {
		$this->fields = $fields;
		return $this;
	}

	/**
	 * @param FieldInterface $field
	 *
	 * @return FormInterface
	 */
	public function addField( FieldInterface $field ): FormInterface {
		$this->fields->set( $field->getName(), $field );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function render(): string {
		return $this
			->getFormStyle()
			->renderForm( $this );
	}

	/**
	 * @inheritDoc
	 */
	public function getSubmittedValues(): SubmittedValuesInterface {
		$values = $_REQUEST[ $this->getId() ] ?? [];
		return new SubmittedValues( $values );
	}

}
