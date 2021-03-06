<?php

/**
 * Basic encryption.
 *
 * @author Caio Ferreira Silva
 */
class recipher
{
	/**
	 * Private key to encrypt data.
	 *
	 * @author Caio Ferreira Silva
	 * @var string
	 */
	private static $__key;

	/**
	 * Set Private Key.
	 *
	 * @author Caio Ferreira Silva
	 * @param string $string
	 * @return void
	 */
	public static function setKey($string)
	{
		self::$__key = (string) $string;
	}

	/**
	 * Gets the Private Key.
	 *
	 * @author Caio Ferreira Silva
	 * @return string
	 */
	public static function getKey()
	{
		if (is_null(self::$__key)) {
			static::setKey(static::__random());
		}

		return self::$__key;
	}

	/**
	 * Generates a random Private Key.
	 *
	 * @author Caio Ferreira Silva
	 * @return string
	 */
	private static function __random()
	{
		if (function_exists('random_bytes')) {
			return bin2hex(random_bytes(rand(32, 64)));
		} else {
			return sha1(uniqid());
		}
	}

	/**
	 * Encodes and decodes a string.
	 *
	 * @author Caio Ferreira Silva
	 * @param string $string
	 * @param string $forceKey
	 * @return string
	 */
	public static function process($string, $forceKey = null)
	{
		$secret = $forceKey ?: static::getKey();
		for ($i = 0; $i < strlen($string); $i++) {
			$string[$i] = $string[$i] ^ $secret[$i % strlen($secret)];
		}

		return $string;
	}

	/**
	 * Encodes a string using base64.
	 *
	 * @author Caio Ferreira Silva
	 * @param string $string
	 * @return string
	 */
	public static function encode($string, $forceKey = null)
	{
		return base64_encode(static::process($string, $forceKey));
	}

	/**
	 * Decodes a base64 string.
	 *
	 * @author Caio Ferreira Silva
	 * @param string $string
	 * @param string $forceKey
	 * @return string
	 */
	public static function decode($string, $forceKey = null)
	{
		return static::process(base64_decode($string), $forceKey);
	}
}
