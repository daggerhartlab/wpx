<?php

namespace Wpx\Form;

use DaggerhartLab\Collections\Map\MapInterface;
use DaggerhartLab\Collections\Map\TraversableMap;
use DaggerhartLab\Collections\Map\TypedMap;

class FormBase implements FormInterface {

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

	/**
	 * @param string|null $id
	 */
	public function __construct(string $id, array $fields = [], array $attributes = []) {
		$this->setId( $id );
		$this->setAttributes( new Attributes( $attributes ) );
		$this->setFields( new TypedMap( FieldInterface::class, $fields ) );
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
	public function setFormMethod( string $method ): FormInterface {
		$this->method = $method;

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

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getAttributes(): Attributes {
		return $this->attributes;
	}

	/**
	 * @inheritDoc
	 */
	public function setAttributes( Attributes $attributes ): FormInterface {
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
	 * @inheritDoc
	 */
	public function setFormStyle( FormStyleInterface $style ): FormInterface {
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
	 * @inheritDoc
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
		$values = $_REQUEST[$this->getId()] ?? [];
		return new TraversableMap($values);
	}

}
