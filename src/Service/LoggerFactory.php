<?php

namespace Wpx\Service;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Wpx\Logger\UserLogger;

/**
 * Class LoggerFactory.
 *
 * @package Wpx\Service
 */
class LoggerFactory {

	/**
	 * @var \wpdb
	 */
	protected $database;

	/**
	 * @param \wpdb $database
	 */
	public function __construct(\wpdb $database) {
		$this->database = $database;
	}

	/**
	 * Create a new logger instance.
	 *
	 * @param string $channel
	 *
	 * @return \Psr\Log\LoggerInterface
	 */
	public function createFileLogger(string $channel, string $folder, int $log_level = UserLogger::ERROR) {
		$file = rtrim($folder, '/') . '/' . str_replace('.', '-', $channel) . '.log';
		$logger = new UserLogger($channel);
		$logger->useMicrosecondTimestamps(false);
		$logger->pushHandler(new RotatingFileHandler($file, 10, $log_level));
		$logger->pushProcessor(new PsrLogMessageProcessor());
		return $logger;
	}

}
