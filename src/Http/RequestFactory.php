<?php

namespace Wpx\Http;

use Symfony\Component\HttpFoundation\Request;

/**
 * Separate the factory methods from the result object.
 */
class RequestFactory extends Request implements RequestFactoryInterface {

	/**
	 * @inheritDoc
	 */
	public static function createFromGlobals() {
		return Request::createFromGlobals();
	}

	/**
	 * @inheritDoc
	 */
	public static function create( string $uri, string $method = 'GET', array $parameters = [], array $cookies = [], array $files = [], array $server = [], $content = null ) {
		return Request::create( $uri, $method, $parameters, $cookies, $files, $server, $content );
	}

}
