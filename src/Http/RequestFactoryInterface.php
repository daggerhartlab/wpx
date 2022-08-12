<?php

namespace Wpx\Http;

use Symfony\Component\HttpFoundation\Request;

/**
 * Separate the factories from the objects.
 */
interface RequestFactoryInterface {

	/**
	 * Create new request object.
	 *
	 * @return Request
	 */
	public static function createFromGlobals();

	/**
	 * Creates a Request based on a given URI and configuration.
	 *
	 * The information contained in the URI always take precedence
	 * over the other information (server and parameters).
	 *
	 * @param string               $uri        The URI
	 * @param string               $method     The HTTP method
	 * @param array                $parameters The query (GET) or request (POST) parameters
	 * @param array                $cookies    The request cookies ($_COOKIE)
	 * @param array                $files      The request files ($_FILES)
	 * @param array                $server     The server parameters ($_SERVER)
	 * @param string|resource|null $content    The raw body data
	 *
	 * @return Request
	 */
	public static function create( string $uri, string $method = 'GET', array $parameters = [], array $cookies = [], array $files = [], array $server = [], $content = null );

}
