<?php

class App implements \Cog\Middleware
{
	public function call($request, $response)
	{
		$response->appendContent('Hi');
		return $response;
	}

}