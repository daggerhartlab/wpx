<?php

namespace Wpx\Messenger;

/**
 * Queue for global messages.
 *
 * @package Wpx\Messenger
 */
class MessengerGlobal implements MessengerInterface {

	/**
	 * Option name for the messages.
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
	 * @param string $name
	 *   Storage name for queue.
	 * @param bool $enqueue
	 *   Automatically show messages as WordPress admin notices.
	 */
	public function __construct( string $name = 'wpx_global_messages', bool $enqueue = true ) {
		$this->setName( $name );
		$this->load();

		if ( $enqueue ) {
			\add_action( 'admin_notices', [ $this, 'renderMessages' ] );
		}
	}
	/**
	 * {@inheritDoc}
	 */
	public function add( $message, $type ) {
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
	public function get() {
		if ( ! empty( $this->items ) ) {
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
		$items = \get_option( $this->name, [] );
		if ( $items ) {
			$this->items = $items;
		}
	}

	/**
	 * Save items to queue.
	 */
	public function save() {
		\update_option( $this->name, $this->items );
	}

	/**
	 * Delete the entire queue.
	 */
	public function delete() {
		\delete_option( $this->name );
	}

	/**
	 * Render the messages.
	 */
	public function render() {
		$messages = $this->get();
		foreach ( $messages as $message ) {
			?>
			<div class="<?php print $message['type'] ?> notice is-dismissible">
				<p><?php print $message['message'] ?></p>
			</div>
			<?php
		}
	}

}
