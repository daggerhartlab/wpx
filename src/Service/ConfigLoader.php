<?php

namespace Wpx\Service;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Config loader will find config default value files stored as yaml in plugins.
 */
class ConfigLoader implements ConfigLoaderInterface {

	/**
	 * @var array[]
	 */
	protected $items = [];

	/**
	 * Config loader constructor.
	 */
	public function __construct() {
		$this->loadDefaults();
	}

	/**
	 * Load default values for config items.
	 * Looks in each plugin's /config folder for yaml files.
	 *
	 * @return void
	 */
	protected function loadDefaults() {
		$finder = new Finder();
		$finder
			->ignoreUnreadableDirs()
			->in( WP_CONTENT_DIR . '/plugins/*/config' )
			->files()
			->name( ['*.yml', '*.yaml'] );

		foreach ($finder as $file) {
			$config_name = $file->getBasename( '.' . $file->getExtension() );
			$this->items[ $config_name ] = Yaml::parseFile( $file->getRealPath() );
		}
	}

	/**
	 * @inheritDoc
	 */
	public function has( string $config_name ): bool {
		return isset( $this->items[ $config_name ] );
	}

	/**
	 * @inheritDoc
	 */
	public function get( string $config_name ): array {
		return $this->items[ $config_name ];
	}

}
