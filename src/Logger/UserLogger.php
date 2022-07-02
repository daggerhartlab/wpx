<?php

namespace Wpx\Logger;

use DateTimeZone;
use Monolog\DateTimeImmutable;
use Monolog\Logger;

/**
 * Logger that adds WP uid context to each log.
 */
class UserLogger extends Logger {

	/**
	 * Constructor.
	 *
	 * @param string $name
	 *   Channel name.
	 * @param array $handlers
	 *   Log handlers.
	 * @param array $processors
	 *   Log processors.
	 * @param \DateTimeZone|null $timezone
	 *   Timezone.
	 */
	public function __construct(string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null ) {
		parent::__construct( $name, $handlers, $processors, $timezone );
	}

	/**
	 * {@inheritDoc}
	 */
	public function addRecord( int $level, string $message, array $context = [], DateTimeImmutable $datetime = null ): bool {
		$context['uid'] = (function_exists('get_current_user_id') && function_exists('did_action') && \did_action('plugins_loaded')) ?
			\get_current_user_id() :
			0;

		return parent::addRecord( $level, $message, $context, $datetime );
	}

}
