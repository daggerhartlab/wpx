<?php

namespace Wpx\Form\Collection;

use Wpx\Form\Model\ElementInterface;

class ElementsCollection extends SortableTypedMap implements ElementsCollectionInterface {

	/**
	 * @return string
	 */
	public static function interface(): string {
		return ElementInterface::class;
	}

}
