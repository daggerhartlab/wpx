<?php

namespace Wpx\Form\Model;

class FieldBase extends ControlBase implements FieldInterface {

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @var bool
	 */
	protected $required = false;

	/**
	 * @inheritDoc
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @inheritDoc
	 */
	public function setValue( $value ): FieldInterface {
		$this->value = $value;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function isRequired(): bool {
		return $this->required;
	}

	/**
	 * @inheritDoc
	 */
	public function setRequired( bool $required = true ): FieldInterface {
		$this->required = $required;
		return $this;
	}

}
