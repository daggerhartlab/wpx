<?php

namespace Wpx\Plugin;

use Wpx\DependencyInjection\ContainerInjectionInterface;

interface TaxonomyInterface extends ContainerInjectionInterface {

	/**
	 * Taxonomy slug.
	 *
	 * @return string
	 */
	public static function slug();

	/**
	 * Register the taxonomy.
	 *
	 * @return void
	 */
	public function register();

}
