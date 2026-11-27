<?php

namespace Wpx\Config;

/**
 * Interface proxy for config objects.
 *
 * Keys may be dot-delimited paths into nested values, e.g. "section.item".
 */
interface ConfigInterface {

	/**
	 * Whether the config contains a value for the key.
	 *
	 * @param string $key
	 *   Key or dot-delimited path.
	 *
	 * @return bool
	 */
	public function has( $key ): bool;

	/**
	 * Get a config value.
	 *
	 * @param string $key
	 *   Key or dot-delimited path.
	 * @param mixed $default
	 *   Returned when the key does not exist.
	 *
	 * @return mixed
	 */
	public function get( $key, $default = null );

	/**
	 * Set a config value.
	 *
	 * @param string $key
	 *   Key or dot-delimited path.
	 * @param mixed $value
	 *   Value to set.
	 *
	 * @return ConfigInterface
	 */
	public function set( $key, $value ): ConfigInterface;

	/**
	 * Remove a config value.
	 *
	 * @param string $key
	 *   Key or dot-delimited path.
	 *
	 * @return ConfigInterface
	 */
	public function remove( $key ): ConfigInterface;

	/**
	 * Get all config values.
	 *
	 * @return array
	 */
	public function all(): array;

	/**
	 * Save the config value.
	 *
	 * @return bool
	 *   Whether the save was successful.
	 */
	public function save(): bool;

}
