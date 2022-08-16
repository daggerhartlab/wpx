<?php

namespace Wpx\Config;

use DaggerhartLab\Collections\Map\TraversableMap;

/**
 * Config object based on wp_options value.
 */
class ConfigOptions extends TraversableMap implements ConfigInterface {

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
	 * @var array
	 */
	protected $data = [];

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
		parent::__construct( $data );
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
	public function save(): bool {
		return \update_option( $this->optionName, $this->all(), $this->autoload );
	}

}
