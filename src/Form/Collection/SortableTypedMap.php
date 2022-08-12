<?php

namespace Wpx\Form\Collection;

use DaggerhartLab\Collections\Map\TypedMap;

class SortableTypedMap extends TypedMap {

	/**
	 * @param array $items
	 */
	public function __construct( array $items = [] ) {
		parent::__construct( static::interface(), $items );
	}

	/**
	 * @return string
	 */
	public static function interface(): string {
		return static::class;
	}

	/**
	 * @return static
	 */
	public function sortedByOrder(): self {
		$items = $this->all();

		uasort( $items, function($a, $b) {
			return $a->getOrder() <=> $b->getOrder();
		} );

		return new static( $items );
	}

}
