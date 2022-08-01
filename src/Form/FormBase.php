<?php

namespace Wpx\Form;

use DaggerhartLab\Collections\Map\Map;
use DaggerhartLab\Collections\Map\MapInterface;
use DaggerhartLab\Collections\Map\TraversableMap;
use DaggerhartLab\Collections\Map\TypedMap;

abstract class FormBase implements FormInterface {

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $method = 'POST';

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
	protected $style;

	/**
	 * @var MapInterface
	 */
	protected $fields;

	public function __construct() {
		$this->setFormAttributes( new Attributes() );
		$this->setFields( new TypedMap( FieldInterface::class ) );
	}

	/**
	 * @inheritDoc
	 */
	public function getFormId(): string {
		return $this->id;
	}

	/**
	 * @inheritDoc
	 */
	public function getFormMethod(): string {
		return $this->method;
	}

	/**
	 * @param string $method
	 *
	 * @return FormBase
	 */
	public function setFormMethod( string $method ): FormBase {
		$this->method = $method;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFormAction(): string {
		return $this->action;
	}

	/**
	 * @param string $action
	 *
	 * @return FormBase
	 */
	public function setFormAction( string $action ): FormBase {
		$this->action = $action;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFormAttributes(): Attributes {
		return $this->attributes;
	}

	/**
	 * @param Attributes $attributes
	 *
	 * @return FormBase
	 */
	public function setFormAttributes( Attributes $attributes ): FormBase {
		$this->attributes = $attributes;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFormStyle(): FormStyleInterface {
		return $this->style;
	}

	/**
	 * @param FormStyleInterface $style
	 *
	 * @return FormBase
	 */
	public function setFormStyle( FormStyleInterface $style ): FormBase {
		$this->style = $style;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFields(): MapInterface {
		return $this->fields;
	}

	/**
	 * @param MapInterface $fields
	 *
	 * @return FormInterface
	 */
	public function setFields( MapInterface $fields ): FormInterface {
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
		return $this->getFormStyle()->renderForm( $this );
	}

	/**
	 * @inheritDoc
	 */
	public function getSubmittedValues(): MapInterface {
		$values = $_REQUEST[$this->getFormId()] ?? [];
		return new TraversableMap($values);
	}

}
