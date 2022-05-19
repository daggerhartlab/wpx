<?php

/**
 * @file
 * DI Container configuration.
 *
 * @link https://php-di.org/doc/php-definitions.html#definition-types
 *
 * Generally, we'll want to use the factory approach. Unlike the Factory pattern
 * this doesn't create a new instance each time the service is requested, it
 * means that the service is instantiated once when called, then stored for
 * future calls.
 * @link https://php-di.org/doc/php-definitions.html#factories
 */

use Psr\Container\ContainerInterface;
use Wpx\Messenger\MessengerUser;
use Wpx\Service\EnvironmentDetector;
use Wpx\Service\LoggerFactory;
use function DI\create;

// @codingStandardsIgnoreStart
return [
	'current_user' => function() {
		return wp_get_current_user();
	},
	'database' => function() {
		global $wpdb;
		return $wpdb;
	},
	'env.detector' => create( EnvironmentDetector::class ),
	'logger.factory' => function( ContainerInterface $container ) {
		return new LoggerFactory( $container->get( 'database' ) );
	},
	'logger.channel.default' => function( ContainerInterface $container ) {
		return $container->get( 'logger.factory' )->channel(
			$container->get('current_user'),
			'default'
		);
	},
	'messenger' => function( ContainerInterface $container ) {
		return new MessengerUser( $container->get( 'current_user' ) );
	}
];
// @codingStandardsIgnoreEnd
