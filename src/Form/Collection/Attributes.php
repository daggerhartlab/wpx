<?php

namespace Wpx\Form\Collection;

use DaggerhartLab\Collections\Map\Map;

class Attributes extends Map implements AttributesInterface {

	/**
	 * Convert the map into an HTML attributes string.
	 *
	 * @return string
	 */
	public function render(): string {
		$strings = [];
		foreach ($this->all() as $key => $value) {
			$string_value = is_array($value) ? implode(' ', $value) : $value;
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

}
