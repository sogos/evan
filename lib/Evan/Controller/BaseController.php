<?php

namespace Evan\Controller;

use Evan\Request\Request;

class BaseController
{

	public function index(Request $request,Array $toto = null)
	{
		echo "coucou" . $toto;
		die();
	}

}