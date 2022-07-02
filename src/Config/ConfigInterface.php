<?php

namespace Wpx\Config;

use DaggerhartLab\Collections\RegistryInterface;

/**
 * Interface proxy for config objects.
 */
interface ConfigInterface extends RegistryInterface {

	/**
	 * Save the config value.
	 *
	 * @return bool
	 *   Whether the save was successful.
	 */
	public function save(): bool;

}
