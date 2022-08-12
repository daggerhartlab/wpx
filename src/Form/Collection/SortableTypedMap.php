<?php

namespace Wpx\Form\Collection;

use DaggerhartLab\Collections\Map\TypedMap;

class SortableTypedMap extends TypedMap implements SortableTypedMapInterface {

	/**
	 * @inheritDoc
	 */
	public function __construct( array $items = [] ) {
		parent::__construct( static::interface(), $items );
	}

	/**
	 * @inheritDoc
	 */
	public static function interface(): string {
		return static::class;
	}

	/**
	 * @inheritDoc
	 */
	public function sortedByOrder(): SortableTypedMapInterface {
		$items = $this->all();

		uasort( $items, function($a, $b) {
			return $a->getOrder() <=> $b->getOrder();
		} );

		return new static( $items );
	}

}
