<?php

namespace Wpx\Service;

/**
 * Config loader will find config default value files stored as yaml in plugins.
 */
interface ConfigLoaderInterface {
	/**
	 * @param string $config_name
	 *
	 * @return bool
	 */
	public function has( string $config_name ): bool;

	/**
	 * @param string $config_name
	 *
	 * @return array
	 */
	public function get( string $config_name ): array;

}
