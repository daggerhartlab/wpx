<?php

namespace Wpx\Cache;

/**
 * Cache item (transient by default).
 */
class CacheItemTransient implements CacheItemInterface {

	/**
	 * Allow the retrieval of invalid (expired) cache items.
	 *
	 * @var bool
	 */
	protected $allowInvalid = false;

	/**
	 * Assume valid, unless it is explicitly invalidated.
	 *
	 * @var bool
	 */
	protected $valid = true;

	/**
	 * Unique cache item name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Expiration timeout in seconds relative to now.
	 *
	 * @var int
	 */
	protected $timeout;

	/**
	 * Data to be cached.
	 *
	 * @var mixed
	 */
	protected $data;

	/**
	 * @param string $cache_id
	 *   Unique cache id.
	 * @param bool $allow_invalid
	 *   Whether invalid (expired) caches can be retrieved.
	 */
	public function __construct( string $cache_id, bool $allow_invalid = false ) {
		$this->name         = $cache_id;
		$this->allowInvalid = $allow_invalid;
		$this->timeout      = (int) \get_option( "_transient_timeout_{$cache_id}" );
		$this->data         = $this->allowInvalid ?
			\get_option( "_transient_{$cache_id}" ) :
			\get_transient( $cache_id );
	}

	/**
	 * @inheritDoc
	 */
	public function expired(): bool {
		return ( $this->timeout > 0 && $this->timeout < time() );
	}

	/**
	 * @inheritDoc
	 */
	public function valid(): bool {
		return ( $this->valid && ! $this->expired() );
	}

	/**
	 * @inheritDoc
	 */
	public function invalidate() {
		$this->valid = false;
	}

	/**
	 * @inheritDoc
	 */
	public function name(): string {
		return $this->name;
	}

	/**
	 * @inheritDoc
	 */
	public function timeout(): int {
		return $this->timeout;
	}

	/**
	 * @inheritDoc
	 */
	public function data() {
		return $this->data;
	}

	/**
	 * @inheritDoc
	 */
	public function setData( $data ) {
		$this->data = $data;
	}

	/**
	 * @inheritDoc
	 */
	public function save( int $timeout ): bool {
		$this->timeout = $timeout;

		// Track actual valid status.
		$this->valid = true;
		if ( ! $this->valid() ) {
			$this->invalidate();
		}

		return \set_transient( $this->name(), $this->data(), $this->timeout() );
	}

	/**
	 * @inheritDoc
	 */
	public function delete(): bool {
		return \delete_transient( $this->name() );
	}
}
