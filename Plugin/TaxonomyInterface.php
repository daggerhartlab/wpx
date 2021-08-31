<?php

namespace Wpx\Plugin;

interface TaxonomyInterface {

	/**
	 * Taxonomy slug.
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
	 * Register the taxonomy.
	 *
	 * @return void
	 */
	public function register();

}
