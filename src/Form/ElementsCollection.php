<?php

namespace Wpx\Form;

use DaggerhartLab\Collections\Map\TypedMap;

class ElementsCollection extends TypedMap {

	/**
	 * @param array $items
	 */
	public function __construct( array $items = [] ) {
		parent::__construct( ElementInterface::class, $items );
	}

	/**
	 * @return ElementsCollection
	 */
	public function sortedByOrder(): ElementsCollection {
		$items = $this->all();

		uasort( $items, function($a, $b) {
			return $a->getOrder() <=> $b->getOrder();
		} );

		return new ElementsCollection( $items );
	}

}
