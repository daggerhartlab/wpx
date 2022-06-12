<?php

namespace Wpx\Config;

use Noodlehaus\AbstractConfig;

/**
 * Config object based on wp_options value.
 */
class OptionsConfig extends AbstractConfig implements ConfigInterface {

	/**
	 * @var int|null
	 */
	protected $blogId;

	/**
	 * @var string
	 */
	protected $optionName;

	/**
	 * @var array
	 */
	protected $data = [];

	/**
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
	 * @param array $data
	 * @param array $default_value
	 * @param string|int|bool $autoload Truthy.
	 * @param int|null $blog_id
	 */
	public function __construct( string $option_name, array $data = [], array $default_value = [], $autoload = null, int $blog_id = null ) {
		$this->optionName = $option_name;
		$this->defaultValue = $default_value;
		$this->autoload = $autoload;
		$this->blogId = $blog_id;
		parent::__construct( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function getDefaults() {
		return $this->defaultValue;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function set( $key, $value ): ConfigInterface {
		parent::set( $key, $value );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function save(): bool {
		return \update_option( $this->optionName, $this->data, $this->autoload );
	}

}
