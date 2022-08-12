<?php

namespace Wpx\Form\Collection;

use Wpx\Form\FormStyle\FormStyleInterface;

class FormStylesCollection extends SortableTypedMap implements FormStylesCollectionInterface {

	/**
	 * @return string
	 */
	public static function interface(): string {
		return FormStyleInterface::class;
	}

}
