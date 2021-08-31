<?php

namespace Wpx\Plugin;

interface PostTypeInterface {

	/**
	 * Post type slug.
	 *
	 * @return string
	 */
	public static function slug();

	/**
	 * Entry point.
	 *
	 * @return void
	 */
	public static function bootstrap();

	/**
	 * Register the post type.
	 *
	 * @return void
	 */
	public function register();

}
