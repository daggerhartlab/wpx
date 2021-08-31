<?php

namespace Wpx\Messenger;

/**
 * Interface MessengerInterface.
 *
 * @package Wpx\Messenger
 */
interface MessengerInterface {

	/**
	 * Add a new item to the message queue.
	 *
	 * @param string $message
	 * @param string $type Either "updated" or "error".
	 */
	public function add( string $message, string $type );

	/**
	 * Get all queued messages.
	 *
	 * @return array
	 */
	public function get();

}
