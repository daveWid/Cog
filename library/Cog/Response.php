<?php

namespace Cog;

/**
 * HTTP Response class.
 *
 * @package Cog
 */
class Response extends \Symfony\Component\HttpFoundation\Response
{
	/**
	 * @param  string $content string
	 * @return \Cog\Response   $this
	 */
	public function appendContent($content)
	{
		$content = $this->getContent().$content;
		return $this->setContent($content);
	}

}
