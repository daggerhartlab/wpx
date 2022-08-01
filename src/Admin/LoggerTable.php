<?php

namespace Wpx\Admin;

use Monolog\Logger;
use WordPressHandler\WordPressHandler;

/**
 * Simple logger table class.
 *
 * @deprecated Not ideal means of handling or displaying database logging. Next Thing TBD.
 */
class LoggerTable extends \WP_List_Table {

	/**
	 * @var \Monolog\Logger
	 */
	protected $logger;

	/**
	 * @var \wpdb
	 */
	protected $database;

	/**
	 * @var \WordPressHandler\WordPressHandler|null
	 */
	protected $handler;

	/**
	 * Construct the table.
	 *
	 * @param \Monolog\Logger $logger
	 *   Logger.
	 * @param \wpdb $database
	 *   Database instance.
	 */
	public function __construct( Logger $logger, \wpdb $database ) {
		$this->logger = $logger;
		$this->database = $database;
		$this->handler = $this->get_log_handler( $logger );
		parent::__construct( [
			'singular'=> 'Log',
			'plural' => 'Logs',
			'ajax'   => false,
		] );
	}

	/**
	 * Get wpdb log handler.
	 *
	 * @param \Monolog\Logger $logger
	 *   Logger.
	 * @return \WordPressHandler\WordPressHandler|null
	 *   WP db log handler.
	 */
	private function get_log_handler( Logger $logger ) {
		foreach ($logger->getHandlers() as $handler) {
			if ($handler instanceof WordPressHandler) {
				return $handler;
			}
		}
		return NULL;
	}

	/**
	 * Get column names.
	 *
	 * @return array
	 */
	public function get_columns() {
		return [
			'id' => __( 'ID' ),
			'channel' => __( 'Channel' ),
			'level' => __( 'Level' ),
			'message' => __( 'Message' ),
			'time' => __( 'Time' ),
			'uid' => __( 'User' ),
		];
	}

	/**
	 * Get array of columns that should be hidden.
	 *
	 * @return string[]
	 */
	public function get_hidden_columns() {
		return ['id', 'channel'];
	}

	/**
	 * Get sortable items.
	 *
	 * @return array[]
	 */
	public function get_sortable_columns() {
		return [
			'time' => [ 'time', true ],
			'uid' => [ 'uid', true ],
		];
	}

	/**
	 * Get total number of log items.
	 *
	 * @return int
	 */
	public function record_count() {
		if (!$this->handler) {
			return 0;
		}

		return (int) $this->database->get_var("SELECT COUNT(*) FROM {$this->handler->get_table_name()}");
	}

	/**
	 * @inheritDoc
	 */
	public function prepare_items() {
		$this->_column_headers = [
			$this->get_columns(),
			$this->get_hidden_columns(),
			$this->get_sortable_columns(),
		];

		$this->process_bulk_action();
		$per_page = $this->get_items_per_page( 'logs_per_page', 50 );
		$current_page = $this->get_pagenum();
		$total_items = $this->record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page' => $per_page //WE have to determine how many items to show on a page
		] );

		$orderby = 'id';
		if ( isset( $_GET['orderby'] ) && in_array( $_GET['orderby'], array_keys( $this->get_columns() ) ) ) {
			$orderby = $_GET['orderby'];
		}
		$order = 'DESC';
		if ( isset( $_GET['order']) && in_array( strtolower( $_GET['order'] ), ['asc', 'desc'] ) ) {
			$order = $_GET['order'];
		}
		$sql = "SELECT * FROM {$this->handler->get_table_name()} ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d";
		$this->items = $this->database->get_results($this->database->prepare($sql, [
				$per_page,
				$per_page * ($current_page - 1),
			]
		), ARRAY_A);
	}

	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'level':
				return $this->logger::getLevelName( $item[ $column_name ] );

			case 'time':
				return date( 'c', $item[ $column_name ] );

			case 'uid':
				$user = get_user_by( 'ID', $item[ $column_name ] );
				return "<a href='" . get_edit_user_link( $user->ID ) . "'>{$user->user_email}</a>";
			default:
				return $item[ $column_name ];
		}
	}

}
