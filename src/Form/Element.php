<?php

namespace Wpx\Form;

class Element implements ElementInterface {

	/**
	 * HTML element.
	 *
	 * @var string
	 */
	protected $element = 'div';

	/**
	 * @var int
	 */
	protected $order = 0;

	/**
	 * Element attributes.
	 *
	 * @var Attributes
	 */
	protected $attributes;

	/**
	 * Relative position.
	 *
	 * @var int
	 */
	protected $position;

	/**
	 * Descriptor content.
	 *
	 * @var string
	 */
	protected $content;

	/**
	 * Child elements.
	 *
	 * @var ElementsCollection
	 */
	protected $children;

	/**
	 * @param string $content
	 * @param array $attributes
	 */
	public function __construct( string $content = '', array $attributes = [] ) {
		$this
			->setContent( $content )
			->setAttributes( new Attributes( $attributes ) )
			->setPosition( ElementInterface::POSITION_BEFORE_FIELD )
		;
	}

	/**
	 * @inheritDoc
	 */
	public function getTag(): string {
		return $this->element;
	}

	/**
	 * @inheritDoc
	 */
	public function setTag( string $element ): ElementInterface {
		$this->element = $element;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getOrder(): int {
		return $this->order;
	}

	/**
	 * @inheritDoc
	 */
	public function setOrder( int $order ): ElementInterface {
		$this->order = $order;
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
	public function setAttributes( Attributes $attributes ): ElementInterface {
		$this->attributes = $attributes;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getPosition(): int {
		return $this->position;
	}

	/**
	 * @inheritDoc
	 */
	public function setPosition( int $position ): ElementInterface {
		$this->position = $position;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getContent(): string {
		return $this->content;
	}

	/**
	 * @inheritDoc
	 */
	public function setContent( string $content ): ElementInterface {
		$this->content = $content;
		return $this;
	}
}
