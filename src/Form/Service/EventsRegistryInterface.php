<?php

namespace Wpx\Form\Service;

use Wpx\Form\Event\EventInterface;

interface EventsRegistryInterface {

	/**
	 * @param string $event_name
	 * @param array $items
	 *
	 * @return EventsRegistryInterface
	 */
	public function registerEvent( string $event_name, array $items = [] ): EventsRegistryInterface;

	/**
	 * @param string $event_name
	 * @param callable $subscriber
	 *
	 * @return  EventsRegistryInterface
	 */
	public function addSubscriber( string $event_name, callable $subscriber ): EventsRegistryInterface;

	/**
	 * @param EventInterface $event
	 * @param string $event_name
	 *
	 * @return void
	 */
	public function dispatchEvent( EventInterface $event, string $event_name ): void;

}
