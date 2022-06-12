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
	 * Get or create a config instance.
	 *
	 * @param string $option_name
	 * @param array $default_value
	 *
	 * @return ConfigInterface
	 */
	public function get(string $option_name, array $default_value = []) {
		if (isset($this->cache[$option_name])) {
			return $this->cache[$option_name];
		}

		return $this->create($option_name, $default_value);
	}

	/**
	 *
	 * @see acf_get_metadata() - For ACF options name pattern.
	 *
	 * @param string $option_name
	 * @param array $default_value
	 * @param null|string|int|bool $autoload
	 *   Truthy.
	 *
	 * @return ConfigInterface
	 */
	public function create(string $option_name, array $default_value = [], $autoload = null) {
		$resolver = new OptionsResolver();
		$resolver->setDefaults($default_value);

		// Get value from DB and allow for ACF values.
		$value = \get_option($option_name, $default_value);
		if (function_exists('get_field') && \get_option("options_{$option_name}") !== false) {
			$value = \get_field($option_name, 'option');
		}

		$data = $resolver->resolve($value);
		$this->cache[$option_name] = new OptionsConfig($option_name, $data, $default_value, $autoload);
		return $this->cache[$option_name];
	}

}
