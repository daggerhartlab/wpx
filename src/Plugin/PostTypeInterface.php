<?php

namespace Wpx\Plugin;

use Wpx\DependencyInjection\ContainerInjectionInterface;

interface PostTypeInterface extends ContainerInjectionInterface {

	/**
	 * Post type slug.
	 *
	 * @return string
	 */
	public static function slug();

	/**
	 * Register the post type.
	 *
	 * @return void
	 */
	public function register();

}
