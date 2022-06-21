<?php

namespace Wpx\Config;

use Noodlehaus\ConfigInterface as NoodlehausConfigInterface;

/**
 * Interface proxy for config objects.
 */
interface ConfigInterface extends NoodlehausConfigInterface {

	/**
	 * Gets a configuration setting using a simple or nested key.
	 * Nested keys are similar to JSON paths that use the dot
	 * notation.
	 *
	 * @param  string $key
	 * @param  mixed  $default
	 *
	 * @return mixed
	 */
	public function get($key, $default = null);

	/**
	 * Set a config item value.
	 *
	 * @param string $key
	 *   Name of the config item.
	 * @param array $value
	 *  Array of values for this config item.
	 *
	 * @return $this
	 */
	public function set( $key, $value ): ConfigInterface;

	/**
	 * @return bool
	 */
	public function save(): bool;

}
