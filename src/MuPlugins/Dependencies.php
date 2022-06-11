<?php

namespace Wpx\MuPlugins;

/**
 * Plugin Name: Wpx Dependencies.
 * Plugin URI: https://www.daggerhartlab.com
 * Description: Enforces plugin dependencies.
 * Version: 0.1
 * Author: daggerhart
 * Author URI: https://www.daggerhartlab.com
 */
class Dependencies {

	/**
	 * To define dependencies in your plugin, add a new plugin header "Dependencies"
	 * that has a value of a comma separated list of plugin file names including
	 * the plugin folder.
	 *
	 * Example--
	 * Dependencies: wordpress-seo/wp-seo.php, classic-editor/classic-editor.php
	 */
	const HEADER = 'Dependencies';

	/**
	 * @return void
	 */
	public static function bootstrap() {
		$static = new static();

		add_filter( 'extra_plugin_headers', [ $static, 'extraPluginHeaders' ] );
		add_action( 'muplugins_loaded', [ $static, 'mupluginsLoaded' ] );
		add_action( 'activate_plugin', [ $static, 'activatePluginDependencies'], 100, 2 );
	}

	/**
	 * Allows for a new Plugins meta attribute that lists other plugins as
	 * dependencies.
	 *
	 * @param array $headers Extra plugin headers.
	 *
	 * @return array
	 *   Altered headers.
	 */
	public function extraPluginHeaders( array $headers = [] ) {
		$headers[ static::HEADER ] = static::HEADER;
		return $headers;
	}

	/**
	 * On load,
	 */
	public function mupluginsLoaded() {
		$active_plugins = get_option( 'active_plugins', [] );
		foreach ( $active_plugins as $active_plugin ) {
			$this->activateInactiveDependencies( $active_plugin );
		}
	}

	/**
	 * Activate plugin's inactive dependencies when the plugin is activated.
	 *
	 * @param string $plugin       Relative plugin filename.
	 * @param bool   $network_wide Network activation or not.
	 */
	public function activatePluginDependencies( $plugin, $network_wide ) {
		$this->activateInactiveDependencies( $plugin );
	}

	/**
	 * Active plugin's inactive dependencies.
	 *
	 * @param string $active_plugin Relative plugin filename.
	 */
	protected function activateInactiveDependencies( string $active_plugin ) {
		$_active_plugin = WP_PLUGIN_DIR . '/' . $active_plugin;
		$active_plugins = get_option( 'active_plugins', [] );
		$plugin_headers = get_file_data( $_active_plugin, [ static::HEADER => static::HEADER ], 'plugin' );
		$inactive_deps  = [];
		if ( ! empty( $plugin_headers[ static::HEADER ] ) ) {
			$dependencies = array_filter( array_map( 'trim', explode( ',', $plugin_headers[ static::HEADER ] ) ) );
			foreach ( $dependencies as $dependency ) {
				if ( ! in_array( $dependency, $active_plugins, true ) ) {
					$inactive_deps[] = $dependency;
				}
			}
		}

		if ( ! empty( $inactive_deps ) ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			activate_plugins( $inactive_deps );
		}
	}

}
