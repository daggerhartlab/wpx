<?php

namespace Wpx\Form\Collection;

use Wpx\Form\Model\FieldTypeInterface;

class ContainersCollection extends SortableTypedMap implements ContainersCollectionInterface {

	/**
	 * @return string
	 */
	public static function interface(): string {
		return FieldTypeInterface::class;
	}

}
