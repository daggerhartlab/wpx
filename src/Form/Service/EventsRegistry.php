<?php

namespace Wpx\Form\Service;

use DaggerhartLab\Collections\Map\Map;
use Wpx\Form\Event\EventInterface;

class EventsRegistry extends Map implements EventsRegistryInterface {

	protected $events = [];

	/**
	 * @inheritDoc
	 */
	public function registerEvent( string $event_name, array $items = [] ): EventsRegistryInterface {
		return $this->set( $event_name, $items );

	}

	/**
	 * @inheritDoc
	 */
	public function addSubscriber( string $event_name, callable $subscriber ): EventsRegistryInterface {
		$subscribers = $this->get( $event_name, [] );
		$subscribers[] = $subscribers;
		$this->set( $event_name, $subscribers );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function dispatchEvent( EventInterface $event, string $event_name ): void {
		$this->invokeCallables( $this->get( $event_name, [] ), [
			'event' => $event,
		] );
	}

	/**
	 * @param array $callables
	 *   Array of callables/invokables.
	 * @param array $context
	 *   Parameters to pass into each callable.
	 *
	 * @return void
	 */
	protected function invokeCallables( array $callables, array $context = [] ) {
		foreach ( $callables as $callable ) {
			call_user_func_array( $callable, $context );
		}
	}

}
