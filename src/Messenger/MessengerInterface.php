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

	/**
	 * Add a new success item to the message queue.
	 *
	 * @param string $message
	 */
	public function addSuccess( string $message );

	/**
	 * Add a new updated item to the message queue.
	 *
	 * @param string $message
	 */
	public function addUpdated( string $message );

	/**
	 * Add a new error item to the message queue.
	 *
	 * @param string $message
	 */
	public function addError( string $message );

}
