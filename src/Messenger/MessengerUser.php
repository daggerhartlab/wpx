<?php

namespace Wpx\Messenger;

/**
 * Queue for user specific messages.
 *
 * @package Wpx\Messenger
 */
class MessengerUser implements MessengerInterface {

	/**
	 * Current user's ID.
	 *
	 * @var int
	 */
	protected $user_id;

	/**
	 * Messages unique meta key name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Array of messages.
	 *
	 * @var array
	 */
	protected $items = [];

	/**
	 * Messenger constructor.
	 *
	 * @param int|\WP_User $user_id
	 *   Current user object or ID.
	 * @param string $name
	 *   Meta key where messages should be stored for the user.
	 */
	public function __construct( $user_id, string $name = 'wpx_user_messages' ) {
		$this->user_id = ( $user_id instanceof \WP_User ) ? $user_id->ID : $user_id;
		$this->setName($name);
		$this->load();
	}

	/**
	 * {@inheritDoc}
	 */
	public function add( string $message, string $type ) {
		$this->items[ md5( $message . $type ) ] = [
			'message' => $message,
			'type' => $type,
			'timestamp' => time(),
		];
		$this->save();
	}

	/**
	 * {@inheritDoc}
	 */
	public function addSuccess( string $message ) {
		$this->add( $message, 'success' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function addUpdated( string $message ) {
		$this->add( $message, 'updated' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function addError( string $message ) {
		$this->add( $message, 'error' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function get() {
		if ( !empty( $this->items ) ) {
			$messages = array_values( $this->items );
			$this->delete();

			return $messages;
		}

		return [];
	}

	/**
	 * Set the name of the meta store.
	 *
	 * @param string $meta_name
	 */
	public function setName( $meta_name ) {
		$this->name = $meta_name;
	}

	/**
	 * Load the queue.
	 */
	public function load() {
		$items = \get_user_meta( $this->user_id, $this->name, true );
		if ( $items ) {
			$this->items = $items;
		}
	}

	/**
	 * Save items to queue.
	 */
	public function save() {
		\update_user_meta( $this->user_id, $this->name, $this->items );
	}

	/**
	 * Delete the entire queue.
	 */
	public function delete() {
		\delete_user_meta( $this->user_id, $this->name );
	}

}
