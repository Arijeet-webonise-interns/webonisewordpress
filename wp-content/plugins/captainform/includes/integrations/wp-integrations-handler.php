<?php
defined('ABSPATH') or die('No direct access!');

class CaptainForm_WP_Integrations_Handler
{
	protected static $public_key;
	protected static $message;
	protected static $signature;
	protected static $api_key;

	public static function init_vars()
	{
		self::$public_key = $_REQUEST["pk"];
		self::$message = $_REQUEST["message"];
		self::$api_key = $_REQUEST["api_key"];
		self::$signature = base64_decode(str_replace(" ", "+", $_REQUEST["signature"]));
	}

	public static function connect($option_db_name = null)
	{
		self::init_vars();

		if (!isset(self::$public_key) || self::$public_key == "") {
			echo self::message("Key is not sent", 0);
			exit();
		}

		if (!isset(self::$api_key) || self::$api_key == "" || self::$api_key != get_option($GLOBALS['captainform_option2'])) {
			echo self::message("Invalid API Key", 0);
			exit();
		}

		$verify = openssl_verify(self::$message, self::$signature, base64_decode(self::$public_key), OPENSSL_ALGO_SHA1);

		if ($verify == 1) {
			if (!get_option($option_db_name)) {
				add_option($option_db_name, self::$public_key);
			} else {
				update_option($option_db_name, self::$public_key);
			}
			echo self::message("WordPress connected", 1);
		} elseif ($verify == 0) {
			echo self::message("Signature not verified", 0);
		} else {
			echo self::message("Error: " . openssl_error_string(), 0);
		}
		exit();
	}

	public static function check_connection($option_db_name)
	{
		if (!self::authenticate($option_db_name)) {
			echo self::message("There was an error while trying to authenticate with wordpress", 0);
			exit();
		}
		echo self::message("Connection OK", 1);
		exit();
	}

	protected static function authenticate($option_db_name)
	{
		if (!get_option($option_db_name)) {
			return false;
		}

		self::$public_key = get_option($option_db_name);
		self::$message = $_REQUEST["message"];
		self::$signature = base64_decode(str_replace(" ", "+", $_REQUEST["signature"]));
		return openssl_verify(self::$message, self::$signature, base64_decode(self::$public_key), OPENSSL_ALGO_SHA1);
	}
	protected static function message($message, $status, $data = '')
	{
		return json_encode(
			array(
				"message" => $message,
				"status" => $status,
				"data" => $data,
			)
		);
	}
	public static function strip_data($data)
	{
		$data = strip_tags(rawurldecode($data));
		$data = preg_replace("/&nbsp;/", ' ', $data);
		$data = stripslashes($data);
		return $data;
	}
}
function RetrieveExtension($data)
{
	$imageContents = base64_decode($data);
	// If its not base64 end processing and return false
	if ($imageContents === false) {
		return false;
	}
	$validExtensions = array('png', 'jpeg', 'jpg', 'gif');
	$tempFile = tmpfile();
	fwrite($tempFile, $imageContents);
	$contentType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tempFile);
	fclose($tempFile);
	if (substr($contentType, 0, 5) !== 'image') {
		return false;
	}	
	$extension = ltrim($contentType, 'image/');	
	if (!in_array(strtolower($extension), $validExtensions)) {
		return false;
	}
	return $extension;
}