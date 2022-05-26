<?php

use DI\ContainerBuilder;

/**
 * Wpx container instance repository and service locator.
 *
 * @link https://php-di.org/doc/best-practices.html
 */
class Wpx {

	/**
	 * The currently active container object, or NULL if not initialized yet.
	 *
	 * @var \Psr\Container\ContainerInterface|null
	 */
	protected static $container;

	/**
	 * Build a new container instance.
	 *
	 * @return \Psr\Container\ContainerInterface
	 *   New container instance.
	 */
	protected static function buildContainer() {
		$builder = new ContainerBuilder();
		$builder->useAutowiring(FALSE);
		$builder->useAnnotations(FALSE);
		$definitions_files = apply_filters( 'wpx.services/definitions', [
			__DIR__ . '/wpx.services.php',
		] );

		foreach ($definitions_files as $file) {
			$builder->addDefinitions($file);
		}

		return $builder->build();
	}

	/**
	 * Get the container.
	 *
	 * @return \Psr\Container\ContainerInterface
	 *   Static container instance.
	 */
	public static function getContainer() {
		if ( static::$container === NULL ) {
			$container = static::buildContainer();
		}

		return $container;
	}

	/**
	 * Returns TRUE if the container has been initialized, FALSE otherwise.
	 *
	 * @return bool
	 */
	public static function hasContainer(): bool {
		return static::$container !== NULL;
	}

	/**
	 * Retrieves a service from the container.
	 *
	 * Use this method if the desired service is not one of those with a dedicated
	 * accessor method below. If it is listed below, those methods are preferred
	 * as they can return useful type hints.
	 *
	 * @param string $id
	 *   The ID of the service to retrieve.
	 *
	 * @return mixed
	 *   The specified service.
	 */
	public static function service( string $id ) {
		return static::getContainer()->get( $id );
	}

	/**
	 * Indicates if a service is defined in the container.
	 *
	 * @param string $id
	 *   The ID of the service to check.
	 *
	 * @return bool
	 *   TRUE if the specified service exists, FALSE otherwise.
	 */
	public static function hasService( $id ): bool {
		// Check hasContainer() first in order to always return a Boolean.
		return static::hasContainer() && static::getContainer()->has($id);
	}

	/**
	 * Get WordPress database instance.
	 *
	 * @return \wpdb
	 *   WordPress database instance.
	 */
	public static function database() {
		return static::service( 'database' );
	}

	/**
	 * Get current active WordPres user.
	 *
	 * @return \WP_User
	 *   Current WP user.
	 */
	public static function currentUser() {
		return static::service( 'current_user' );
	}

	/**
	 * Get environment detector.
	 *
	 * @return \Wpx\Service\EnvironmentDetector
	 *   Environment detector.
	 */
	public static function environment() {
		return static::service( 'env.detector' );
	}

	/**
	 * Get Logger factory.
	 *
	 * @return \Wpx\Service\LoggerFactory
	 *   Logger factory.
	 */
	public static function loggerFactory() {
		return static::service('logger_factory');
	}

	/**
	 * Get messenger instance.
	 *
	 * @return \Wpx\Messenger\MessengerInterface
	 *   Messenger instance.
	 */
	public static function messenger() {
		return static::service( 'messenger' );
	}

}
