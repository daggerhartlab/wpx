<?php

namespace Wpx\Form\Collection;

use DaggerhartLab\Collections\CollectionInterface;
use DaggerhartLab\Collections\Map\Map;

class Attributes extends Map implements AttributesInterface {

	/**
	 * @param array $items
	 */
	public function __construct( array $items = [] ) {
		parent::__construct( $items );
	}

	/**
	 * Convert the map into an HTML attributes string.
	 *
	 * @return string
	 */
	public function render(): string {
		$strings = [];
		foreach ($this->all() as $key => $value) {
			$string_value = is_array($value) ? implode(' ', $value) : $value;
			// @todo - remove WP specific.
			$strings[] = "{$key}='" . \esc_attr( $string_value ) . "'";
		}

		return implode(' ', $strings);
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		return $this->render();
	}

	/**
	 * {@inheritdoc}
	 */
	public function filter(callable $callable = null, int $mode = 0): CollectionInterface {
		return new static(call_user_func_array('array_filter', array_filter([
			$this->all(),
			$callable,
			$mode
		]) ?: [[]] ));
	}

}
