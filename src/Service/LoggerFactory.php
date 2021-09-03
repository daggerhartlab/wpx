<?php

namespace Wpx\Service;

use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use WordPressHandler\WordPressHandler;
use Wpx\Logger\UserLogger;

/**
 * Class LoggerFactory.
 *
 * @link https://github.com/bradmkjr/monolog-wordpress
 *
 * @package Wpx\Service
 */
class LoggerFactory {

	/**
	 * WP database.
	 *
	 * @var \wpdb
	 */
	protected $wpdb;

	/**
	 * Logging levels by name.
	 *
	 * @var string
	 */
	protected $levels = [
		'disabled' => Logger::EMERGENCY,
		'error' => Logger::ERROR,
		'debug' => Logger::DEBUG,
		'info' => Logger::INFO,
	];

	/**
	 * Log level name.
	 *
	 * @var string
	 */
	protected $levelName = 'info';

	/**
	 * Log level.
	 *
	 * @var int
	 */
	protected $level = Logger::INFO;

	/**
	 * Logs retention limit.
	 *
	 * @var int
	 */
	protected $limit = 25000;

	/**
	 * LoggerFactory constructor.
	 *
	 * @param string|null $level_name
	 *   Log level name.
	 * @param int|null $limit
	 *   Log retention limit.
	 */
	public function __construct( \wpdb $wpdb, string $level_name = null, int $limit = null ) {
		$this->wpdb = $wpdb;
		if ( $level_name && isset( $this->levels[ $level_name ] ) ) {
			$this->levelName = $level_name;
			$this->level = $this->levels[ $level_name ];
		}
		if ( $limit ) {
			$this->limit = $limit;
		}
	}

	/**
	 * Get database handler based on plugin settings.
	 *
	 * @return \WordPressHandler\WordPressHandler
	 */
	public function getDbHandler() {
		$handler = new WordPressHandler( $this->wpdb, 'logs', ['uid'], $this->level );
		$handler->conf_table_size_limiter( $this->limit );
		return $handler;
	}

	/**
	 * Get a logger for the given channel name.
	 *
	 * @param \WP_User $user
	 *   User context.
	 * @param string $name
	 *   Channel name.
	 * @param HandlerInterface[] $handlers
	 *   Provide custom handlers to the logger.
	 *
	 * @return LoggerInterface
	 */
	public function channel( \WP_User $user, string $name, $handlers = [] ) {
		$logger = new UserLogger( $user, $name );
		foreach ( $handlers as $handler ) {
			$logger->pushHandler( $handler );
		}

		if ( empty( $logger->getHandlers() ) ) {
			$logger->pushHandler( $this->getDbHandler() );
		}

		return $logger;
	}

}
