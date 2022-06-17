<?php

namespace Wpx\Service;

use Wpx\Config\ConfigInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wpx\Config\ConfigOptions;

/**
 * Config factory service for OptionsConfig instances.
 */
class ConfigFactory implements ConfigFactoryInterface {

	/**
	 * @var ConfigInterface[]
	 */
	private $cache = [];

	/**
	 * @var ConfigLoaderInterface
	 */
	protected $configLoader;

	/**
	 * @param ConfigLoaderInterface $config_loader
	 */
	public function __construct(ConfigLoaderInterface $config_loader) {
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
	 * @inheritDoc
	 */
	public function get( string $config_name, array $default_value = [] ) {
		if ( isset( $this->cache[ $config_name ] ) ) {
			return $this->cache[ $config_name ];
		}

		$default_value = $this->resolveConfigDefaultValue( $config_name, $default_value );

		return $this->create( $config_name, $default_value );
	}

	/**
	 * Create a new config object instance.
	 *
	 * @see get_option() - For core WordPress option names.
	 * @see acf_get_metadata() - For ACF options name pattern.
	 *
	 * @param string $config_name
	 *   Name of the config value in the config's storage.
	 * @param array $default_value
	 *   Override the default values for the config item.
	 * @param null|string|int|bool $autoload
	 *   Truthy.
	 *
	 * @return ConfigInterface
	 */
	protected function create( string $config_name, array $default_value = [], $autoload = null ) {
		$default_value = $this->resolveConfigDefaultValue( $config_name, $default_value );

		// Get value from DB and allow for ACF values.
		$value = \get_option( $config_name, $default_value );
		if ( function_exists( 'get_field' ) && \get_option( "options_{$config_name}" ) !== false ) {
			$value = \get_field( $config_name, 'option' );
		}

		// If the value is a numeric array, unset the default value so the
		// config constructor's array_merge does not double the values.
		if (
			is_array( $value ) &&
			array_key_first( $value ) === 0 &&
			!empty( $default_value ) &&
			array_key_first( $default_value ) === 0
		) {
			$default_value = array_replace( $value, $default_value, $value );
		}

		$resolver = new OptionsResolver();
		$resolver->setDefaults( $default_value );

		$data = $resolver->resolve( $value );
		$this->cache[ $config_name ] = new ConfigOptions( $config_name, $data, $default_value, $autoload );

		return $this->cache[ $config_name ];
	}

}
