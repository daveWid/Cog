<?php

class App implements \Cog\Middleware
{
	public function call($request, $response)
	{
		$response->appendBody('Hi');
		return $response;
	}

}