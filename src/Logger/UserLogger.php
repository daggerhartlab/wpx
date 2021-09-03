<?php

namespace Wpx\Logger;

use DateTimeZone;

/**
 * Logger that adds WP uid context to each log.
 */
class UserLogger extends \Monolog\Logger {

	/**
	 * User context.
	 *
	 * @var \WP_User
	 */
	protected $user;

	/**
	 * Constructor.
	 *
	 * @param \WP_User $user
	 *   User context.
	 * @param string $name
	 *   Channel name.
	 * @param array $handlers
	 *   Log handlers.
	 * @param array $processors
	 *   Log processors.
	 * @param \DateTimeZone|null $timezone
	 *   Timezone.
	 */
	public function __construct( \WP_User $user, string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null ) {
		$this->user = $user;
		parent::__construct( $name, $handlers, $processors, $timezone );
	}

	/**
	 * {@inheritDoc}
	 */
	public function addRecord( int $level, string $message, array $context = [] ): bool {
		$context['uid'] = $this->user->ID;
		return parent::addRecord( $level, $message, $context );
	}

}