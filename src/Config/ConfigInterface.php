<?php

namespace Wpx\Config;

use Noodlehaus\ConfigInterface as NoodlehausConfigInterface;

/**
 * Interface proxy for config objects.
 */
interface ConfigInterface extends NoodlehausConfigInterface {

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function set( $key, $value );

	/**
	 * @return bool
	 */
	public function save(): bool;

}
