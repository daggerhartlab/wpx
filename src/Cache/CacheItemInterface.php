<?php

namespace Wpx\Cache;

/**
 * Cache items are data stores expire after a time interval.
 */
interface CacheItemInterface {

	/**
	 * Whether the cache item has expired.
	 *
	 * @return bool
	 */
	public function expired(): bool;

	/**
	 * Whether the cache item hasn't expired.
	 *
	 * @return bool
	 */
	public function valid(): bool;

	/**
	 * Mark the cache item as invalid.
	 */
	public function invalidate();

	/**
	 * Get the name of the cache item.
	 *
	 * @return string
	 */
	public function name(): string;

	/**
	 * Get the defined timeout of the cache item.
	 *
	 * @return int
	 */
	public function timeout(): int;

	/**
	 * Get the data stored in cache.
	 *
	 * @return mixed
	 */
	public function data();

	/**
	 * Set the data on the cache item.
	 *
	 * @param mixed $data
	 */
	public function setData( $data );

	/**
	 * Save the data to cache.
	 *
	 * @param int $timeout
	 *   Time in seconds the cache item should expire from now.
	 *
	 * @return bool
	 */
	public function save( int $timeout ): bool;

}
