<?php

namespace Wpx\Service;

/**
 * Utility for determining environment code is running in.
 */
class EnvironmentDetector {

	// Dev mode for environments that are not test or live.
	const MODE_DEV = 'dev';

	// Test mode for environments that are not developed on.
	const MODE_TEST = 'test';

	// Live mode for production.
	const MODE_LIVE = 'live';

	/**
	 * Current environment mode.
	 *
	 * @var string
	 */
	protected $mode = 'unknown';

	/**
	 * Current environment name.
	 *
	 * @var string
	 */
	protected $env = 'unknown';

	/**
	 * Current environment host.
	 *
	 * @var string
	 */
	protected $host = 'unknown';

	/**
	 * Other arbitrary or site specific environment values.
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Construct the class.
	 */
	public function __construct() {
		$this->detectEnvironment();
	}

	/**
	 * Detect the current environment values.
	 */
	public function detectEnvironment() {
		if (getenv('PANTHEON_ENVIRONMENT')) {
			$this->host = getenv('LANDO_WEBROOT') ? 'lando' : 'pantheon';
			$this->mode = self::MODE_DEV;
			$this->env = getenv('PANTHEON_ENVIRONMENT');
			// Test environment in test mode.
			if ($this->env == self::MODE_TEST) {
				$this->mode = self::MODE_TEST;
			}
			// Live environment in live mode.
			if ($this->env == self::MODE_LIVE) {
				$this->mode = self::MODE_LIVE;
			}
		}

		if (getenv('TUGBOAT_ROOT')) {
			$this->host = 'tugboat';
			$this->mode = self::MODE_TEST;
			$this->env = getenv('TUGBOAT_PREVIEW_NAME');
		}

		if (getenv('CI') === 'GITHUB') {
			$this->host = 'github';
			$this->mode = self::MODE_TEST;
			$this->env = getenv('GITHUB_WORKFLOW') . '--' . getenv('GITHUB_RUN_NUMBER');
		}
	}

	/**
	 * Current environment mode.
	 *
	 * @return string
	 */
	public function getMode() {
		return $this->mode;
	}

	/**
	 * Current environment name.
	 *
	 * @return string
	 */
	public function getEnv() {
		return $this->env;
	}

	/**
	 * Current environment host.
	 *
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * Whether we're in production.
	 *
	 * @return bool
	 *   True if in production, otherwise false.
	 */
	public function isLive() {
		return $this->getMode() === self::MODE_LIVE;
	}

	/**
	 * Whether we're on a pantheon hosted environment.
	 *
	 * @return bool
	 *   True if on pantheon, otherwise false.
	 */
	public function isPantheon() {
		return getenv('PANTHEON_ENVIRONMENT') && $this->host !== 'lando';
	}

	/**
	 * Whether we're in a lando environment.
	 *
	 * @return bool
	 *   True if host is lando.
	 */
	public function isLando() {
		return $this->host === 'lando';
	}

	/**
	 * Set an environment data value.
	 *
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return \Wpx\Service\EnvironmentDetector
	 */
	public function set(string $name, $value) {
		$this->data[$name] = $value;
		return $this;
	}

	/**
	 * Get an environment data value.
	 *
	 * @param string $name
	 *   Data value name.
	 * @param null $default
	 *   Default value if not found.
	 * @return mixed|null
	 */
	public function get(string $name, $default = null) {
		return $this->data[$name] ?? $default;
	}

	/**
	 * Get all stored custom data.
	 *
	 * @return array
	 *   Array of custom data.
	 */
	public function getAllData() {
		return $this->data;
	}

}
