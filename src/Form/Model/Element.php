<?php

namespace Wpx\Form\Model;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Collection\AttributesInterface;

class Element implements ElementInterface {

	/**
	 * HTML element.
	 *
	 * @var string
	 */
	protected $tag = 'div';

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
		return $this->tag;
	}

	/**
	 * @inheritDoc
	 */
	public function setTag( string $tag ): ElementInterface {
		$this->tag = $tag;
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
	public function getAttributes(): AttributesInterface {
		return $this->attributes;
	}

	/**
	 * @inheritDoc
	 */
	public function setAttributes( AttributesInterface $attributes ): ElementInterface {
		$this->attributes = $attributes;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function setAttribute( string $name, $value ): ElementInterface {
		$this->getAttributes()->set($name, $value);
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
	public function isEmpty(): bool {
		return empty( array_filter( [
			empty( $this->getContent() ),
			is_null( $this->getAttributes()->get('value') ),
			is_null( $this->getAttributes()->get('type') )
		] ) );
	}

	/**
	 * @inheritDoc
	 */
	public function isVoidElement(): bool {
		return in_array( strtolower( $this->getTag()) , ElementInterface::VOID_ELEMENTS );
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
