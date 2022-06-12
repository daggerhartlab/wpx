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

use Wpx\DependencyInjection\ContainerInterface;
use Wpx\Messenger\MessengerUser;
use Wpx\Service\CacheFactory;
use Wpx\Service\ConfigFactory;
use Wpx\Service\ConfigLoader;
use Wpx\Service\EnvironmentDetector;
use Wpx\Service\LoggerFactory;
use function DI\create;

// @codingStandardsIgnoreStart
return [
	'cache_factory' => create( CacheFactory::class),

	'config_loader' => create( ConfigLoader::class),

	'config_factory' => function( ContainerInterface $container) {
		return new ConfigFactory(
			$container->get('config_loader')
		);
	},

	'current_user' => function() {
		return \wp_get_current_user();
	},

	'database' => function() {
		global $wpdb;
		return $wpdb;
	},

	'env.detector' => create( EnvironmentDetector::class ),

	'logger_factory' => function( ContainerInterface $container ) {
		return new LoggerFactory(
			$container->get( 'database' )
		);
	},

	'messenger' => function( ContainerInterface $container ) {
		return new MessengerUser( $container->get( 'current_user' ) );
	}
];
// @codingStandardsIgnoreEnd
