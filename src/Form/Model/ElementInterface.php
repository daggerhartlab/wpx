<?php

namespace Wpx\Form\Model;

use Wpx\Form\Collection\AttributesInterface;

interface ElementInterface {

	/*
	 * For relative positioning of sub-elements of a field.
	 */
	public const POSITION_HIDDEN = 0;
	public const POSITION_BEFORE_FIELD = 1;
	public const POSITION_AFTER_FIELD = 2;

	/**
	 * Get element.
	 *
	 * @return string
	 */
	public function getTag(): string;

	/**
	 * @param string $tag
	 *
	 * @return ElementInterface
	 */
	public function setTag( string $tag ): ElementInterface;

	/**
	 * Get element order.
	 *
	 * @return int
	 */
	public function getOrder(): int;

	/**
	 * Set element order.
	 *
	 * @param int $order
	 *
	 * @return ElementInterface
	 */
	public function setOrder( int $order ): ElementInterface;

	/**
	 * @return AttributesInterface
	 */
	public function getAttributes(): AttributesInterface;

	/**
	 * @param AttributesInterface $attributes
	 *
	 * @return ElementInterface
	 */
	public function setAttributes( AttributesInterface $attributes ): ElementInterface;

	/**
	 * @param string $name
	 * @param string|array $value
	 *
	 * @return ElementInterface
	 */
	public function setAttribute( string $name, $value ): ElementInterface;

	/**
	 * @return int
	 */
	public function getPosition(): int;

	/**
	 * @param int $position
	 *
	 * @return ElementInterface
	 */
	public function setPosition( int $position ): ElementInterface;

	/**
	 * @return string
	 */
	public function getContent(): string;

	/**
	 * @param string $content
	 *
	 * @return ElementInterface
	 */
	public function setContent( string $content ): ElementInterface;

}
