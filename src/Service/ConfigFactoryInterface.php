<?php

namespace Wpx\Service;


use Wpx\Config\ConfigInterface;

/**
 * Config factory interface.
 */
interface ConfigFactoryInterface {
	/**
	 * Get or create a config instance.
	 *
	 * @param string $config_name
	 *   Name of the config value in the config's storage.
	 * @param array $default_value
	 *   Override the default values for the config item.
	 * @param array $options
	 *   Additional options when creating this config item.
	 *
	 * @return ConfigInterface
	 */
	public function get( string $config_name, array $default_value = [], array $options = [] );
}
