<?php

use DI\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Wpx\DependencyInjection\Container;
use Wpx\DependencyInjection\ContainerInterface;

/**
 * Wpx container instance repository and service locator.
 *
 * @link https://php-di.org/doc/best-practices.html
 */
class Wpx {

	/**
	 * The currently active container object, or NULL if not initialized yet.
	 *
	 * @var ContainerInterface|null
	 */
	protected static $container;

	/**
	 * Build a new container instance.
	 *
	 * @return ContainerInterface
	 *   New container instance.
	 */
	protected static function buildContainer() {
		$builder = new ContainerBuilder( Container::class);
		$builder->useAutowiring(FALSE);
		$builder->useAnnotations(FALSE);

		$definitions_files = static::locateDefinitionsFiles();

		foreach ($definitions_files as $file) {
			$builder->addDefinitions($file);
		}

		/** @var ContainerInterface $container */
		$container = $builder->build();
		return $container;
	}

	/**
	 * Automatically locate plugin's services when defined in a file named
	 * 'wpx.services.php'.
	 *
	 * @return array
	 */
	protected static function locateDefinitionsFiles() {
		$definitions_files = [ __DIR__ . '/wpx.services.php' ];

		$finder = new Finder();
		$finder
			->ignoreUnreadableDirs()
			->in( static::findExtensionsDirectories() )
			->depth('<=1')
			->files()
			->name( 'wpx.services.php' );

		foreach ($finder as $file) {
			$definitions_files[] = $file->getRealPath();
		}

		return apply_filters( 'wpx.services/definitions', $definitions_files );
	}

	/**
	 * Attempt to find WordPress plugins / themes directory.
	 *
	 * @return array
	 */
	protected static function findExtensionsDirectories() {
		if (defined('WP_CONTENT_DIR')) {
			return [
				WP_CONTENT_DIR . '/plugins/*',
				WP_CONTENT_DIR . '/themes/*',
			];
		}

		$find = new Symfony\Component\Finder\Finder();
		$find->directories()
			->path([
				'wp-content/plugins',
				'wp-content/themes',
			])
			->name([
				'plugins',
				'themes',
			])
		    ->in([
				ABSPATH,
			    ABSPATH . '../',
		    ])
		    ->depth('<=3');

		$found = [];
		foreach ($find as $directory) {
			$found[] = $directory->getRealPath() . '/*';
		}
		return $found;
	}

	/**
	 * Get the container.
	 *
	 * @return ContainerInterface
	 *   Static container instance.
	 */
	public static function getContainer(): ContainerInterface {
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
	public static function hasService( string $id ): bool {
		// Check hasContainer() first in order to always return a Boolean.
		return static::hasContainer() && static::getContainer()->has($id);
	}

	/**
	 * @param string $name
	 * @param $default_value
	 *
	 * @return \Wpx\Config\ConfigInterface
	 */
	public static function config( string $name, $default_value = null ): \Wpx\Config\ConfigInterface {
		if ( static::hasService( 'config_factory' ) ) {
			return static::service( 'config_factory' )->create( $name, $default_value );
		}

		throw new \RuntimeException("No config factory found in container.");
	}

	/**
	 * Get WordPress database instance.
	 *
	 * @return \wpdb
	 *   WordPress database instance.
	 */
	public static function database(): \wpdb {
		return static::service( 'database' );
	}

	/**
	 * Get current active WordPres user.
	 *
	 * @return \WP_User
	 *   Current WP user.
	 */
	public static function currentUser(): \WP_User {
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
