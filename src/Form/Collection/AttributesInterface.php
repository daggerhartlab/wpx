<?php

namespace Wpx\Form\Collection;

use DaggerhartLab\Collections\Map\MapInterface;

interface AttributesInterface extends MapInterface {

	/**
	 * Convert the map into an HTML attributes string.
	 *
	 * @return string
	 */
	public function render(): string;

}
