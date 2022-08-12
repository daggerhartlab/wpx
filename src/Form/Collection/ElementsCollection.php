<?php

namespace Wpx\Form\Collection;

use Wpx\Form\ElementInterface;

class ElementsCollection extends SortableTypedMap {

	/**
	 * @return string
	 */
	public static function interface(): string {
		return ElementInterface::class;
	}

}
