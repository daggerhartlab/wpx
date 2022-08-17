<?php

namespace Wpx\Form\Collection;

use Wpx\Form\Model\ControlInterface;
use Wpx\Form\Model\FieldTypeInterface;

class ControlsCollection extends SortableTypedMap implements ControlsCollectionInterface {

	/**
	 * @return string
	 */
	public static function interface(): string {
		return ControlInterface::class;
	}

}
