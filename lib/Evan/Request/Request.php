<?php

namespace Evan\Request;

class Request
{

	protected $server_method;
	protected $uri;
	protected $lang;

	public function __construct() {

		$this->server_method = $_SERVER['REQUEST_METHOD'];
		$this->uri = $_SERVER['REQUEST_URI'];
		try {
			$this->lang = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		} catch(\Exception $e) {
			die($e->getMessage());
		}
	}

	public function getMethod()
	{
		return $this->server_method;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function getBrowserLang()
	{
		return $this->lang;
	}
}