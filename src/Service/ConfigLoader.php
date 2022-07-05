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
			$this->items[ $config_name ] = $this->yamlParse( $file->getRealPath() );
		}
	}

	/**
	 * Parse contents of given file name.
	 *
	 * @param string $filepath
	 *   Yaml absolute filepath.
	 *
	 * @return array
	 *   Results.
	 */
	protected function yamlParse( string $filepath ) {
		if ( method_exists( Yaml::class, 'parseFile' ) ) {
			return Yaml::parseFile( $filepath );
		}

		return Yaml::parse( file_get_contents( $filepath ) );
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
