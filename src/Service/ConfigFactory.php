<?php

namespace Wpx\Service;

use Wpx\Config\ConfigInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wpx\Config\OptionsConfig;

/**
 * Config factory service.
 */
class ConfigFactory {

	/**
	 * @var ConfigInterface[]
	 */
	private $cache = [];

	/**
	 * @var ConfigLoader
	 */
	protected $configLoader;

	/**
	 * @param ConfigLoader $config_loader
	 */
	public function __construct(ConfigLoader $config_loader) {
		$this->configLoader = $config_loader;
	}

	/**
	 * @param string $config_name
	 * @param array $default_value
	 *
	 * @return array
	 */
	protected function resolveConfigDefaultValue( string $config_name, array $default_value ): array {
		if ( empty($default_value) && $this->configLoader->has( $config_name ) ) {
			$default_value = $this->configLoader->get( $config_name );
		}

		return $default_value;
	}

	/**
	 * Get or create a config instance.
	 *
	 * @param string $config_name
	 * @param array $default_value
	 *   Override the default values for the config item.
	 *
	 * @return ConfigInterface
	 */
	public function get( string $config_name, array $default_value = [] ) {
		if ( isset( $this->cache[ $config_name ] ) ) {
			return $this->cache[ $config_name ];
		}

		$default_value = $this->resolveConfigDefaultValue( $config_name, $default_value );

		return $this->create( $config_name, $default_value );
	}

	/**
	 *
	 * @param string $config_name
	 * @param array $default_value
	 *   Override the default values for the config item.
	 * @param null|string|int|bool $autoload
	 *   Truthy.
	 *
	 * @return ConfigInterface
	 * @see acf_get_metadata() - For ACF options name pattern.
	 *
	 */
	public function create( string $config_name, array $default_value = [], $autoload = null ) {
		$default_value = $this->resolveConfigDefaultValue( $config_name, $default_value );

		$resolver = new OptionsResolver();
		$resolver->setDefaults( $default_value );

		// Get value from DB and allow for ACF values.
		$value = \get_option( $config_name, $default_value );
		if ( function_exists( 'get_field' ) && \get_option( "options_{$config_name}" ) !== false ) {
			$value = \get_field( $config_name, 'option' );
		}

		$data = $resolver->resolve( $value );
		$this->cache[ $config_name ] = new OptionsConfig( $config_name, $data, $default_value, $autoload );

		return $this->cache[ $config_name ];
	}

}
