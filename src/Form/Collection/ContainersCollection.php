<?php

namespace Wpx\Form\Collection;

use Wpx\Form\Model\FieldInterface;

class ContainersCollection extends SortableTypedMap implements ContainersCollectionInterface {

	/**
	 * @return string
	 */
	public static function interface(): string {
		return FieldInterface::class;
	}

}
