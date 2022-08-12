<?php

namespace Wpx\Form;

use Wpx\Form\Collection\Attributes;

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
	 * @param string $element
	 *
	 * @return ElementInterface
	 */
	public function setTag( string $element ): ElementInterface;

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
	 * @return Attributes
	 */
	public function getAttributes(): Attributes;

	/**
	 * @param Attributes $attributes
	 *
	 * @return ElementInterface
	 */
	public function setAttributes( Attributes $attributes ): ElementInterface;

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
