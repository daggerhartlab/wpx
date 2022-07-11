<?php

namespace Wpx\Config;

use DaggerhartLab\Collections\Map\MapInterface;

/**
 * Interface proxy for config objects.
 */
interface ConfigInterface extends MapInterface {

	/**
	 * Save the config value.
	 *
	 * @return bool
	 *   Whether the save was successful.
	 */
	public function save(): bool;

}
