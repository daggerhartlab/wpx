<?php

namespace Wpx\Form\Collection;

use Wpx\Form\FieldInterface;

class FieldsCollection extends SortableTypedMap implements FieldsCollectionInterface {

	/**
	 * @return string
	 */
	public static function interface(): string {
		return FieldInterface::class;
	}

}
