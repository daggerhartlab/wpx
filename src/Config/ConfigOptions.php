<?php

namespace Wpx\Config;

use Dflydev\DotAccessData\Data;

/**
 * Config object based on wp_options value.
 */
class ConfigOptions implements ConfigInterface {

	/**
	 * WP Blog id (in support of multisite).
	 *
	 * @var int|null
	 */
	protected $blogId;

	/**
	 * Unique config item name.
	 *
	 * @var string
	 */
	protected $optionName;

	/**
	 * Actual value for config item.
	 *
	 * @var \Dflydev\DotAccessData\Data
	 */
	protected $items;

	/**
	 * Default value for the config item.
	 *
	 * @var array
	 */
	protected $defaultValue = [];

	/**
	 * Truthy.
	 *
	 * @var null|bool|string
	 */
	protected $autoload;

	/**
	 * @param string $option_name
	 *   Unique name for the config value.
	 * @param array $data
	 *   Actual values.
	 * @param array $default_value
	 *   Default values.
	 * @param string|int|bool $autoload Truthy.
	 *   WordPress option autoload.
	 * @param int|null $blog_id
	 *   Blog Id.
	 */
	public function __construct( string $option_name, array $data = [], array $default_value = [], $autoload = null, int $blog_id = null ) {
		$this->optionName = $option_name;
		$this->defaultValue = $default_value;
		$this->autoload = $autoload;
		$this->blogId = $blog_id;
		$this->setAll( $data );
	}

	/**
	 * Get the default value of the config item.
	 *
	 * @return array
	 *   Default value.
	 */
	public function getDefaults(): array {
		return $this->defaultValue;
	}

	/**
	 * @inheritDoc
	 */
	public function has( $key ): bool {
		return $this->items->has( $key );
	}

	/**
	 * @inheritDoc
	 */
	public function get( $key, $default = null ) {
		return $this->items->get( $key, $default );
	}

	/**
	 * @inheritDoc
	 */
	public function set( $key, $value ): ConfigInterface {
		$this->items->set( $key, $value );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function remove( $key ): ConfigInterface {
		$this->items->remove( $key );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function all(): array {
		return $this->items->export();
	}

	/**
	 * Replace all config values.
	 *
	 * @param array $items
	 *   New values.
	 *
	 * @return ConfigInterface
	 */
	public function setAll( array $items = [] ): ConfigInterface {
		$this->items = new Data( $items );
		return $this;
	}

	/**
	 * Append an item to an array nested within the config.
	 *
	 * @param mixed $item
	 *   Item to append.
	 * @param string $key
	 *   Key or dot-delimited path of the array.
	 *
	 * @return ConfigInterface
	 */
	public function add( $item, $key = null ): ConfigInterface {
		if ( ! $key ) {
			throw new \RuntimeException( 'Key is required. The "add()" method is for appending items to an array nested within the data.' );
		}
		$this->items->append( $key, $item );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function save(): bool {
		return \update_option( $this->optionName, $this->all(), $this->autoload );
	}

}
