<?php

namespace Wpx\Service;

use Wpx\Cache\CacheItemTransient;
use Wpx\Cache\CacheItemInterface;

/**
 * Cache item factory.
 */
class CacheFactory {

	/**
	 * @var CacheItemInterface[]
	 */
	protected $caches = [];

	/**
	 * @param string $cache_id
	 * @param bool $allow_invalid
	 *
	 * @return CacheItemInterface
	 */
	public function get( string $cache_id, bool $allow_invalid = false ) {
		if ( isset( $this->caches[ $cache_id ] ) ) {
			if ( $this->caches[ $cache_id ]->valid() ) {
				return $this->caches[ $cache_id ];
			}

			// Remove invalid caches from this collection.
			unset( $this->caches[ $cache_id ] );
		}

		$this->caches[ $cache_id ] = new CacheItemTransient( $cache_id, $allow_invalid );

		return $this->caches[ $cache_id ];
	}

}
