<?php

namespace Wpx\Form\Collection;

use DaggerhartLab\Collections\Map\MapInterface;

interface SortableTypedMapInterface extends MapInterface {

	/**
	 * The FQN interface/class name for the type of data in the collection.
	 *
	 * @return string
	 */
	public static function interface(): string;

	/**
	 * Sort the collection by items' order properties.
	 *
	 * @return static
	 */
	public function sortedByOrder(): SortableTypedMapInterface;

}
