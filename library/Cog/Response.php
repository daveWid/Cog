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
	 * {@inheritDoc}
	 */
	public function __construct($content = '', $status = 200, $headers = array())
	{
		parent::__construct($content, $status, $headers);
		$this->setProtocolVersion('1.1');
	}

	/**
	 * Adds content to the current body.
	 *
	 * @param  string $content Content to add
	 * @return \Cog\Response   $this
	 */
	public function appendContent($content)
	{
		return $this->setContent($this->getContent().$content);
	}

	/**
	 * {@inheritDoc}
	 */
	public function sendHeaders()
	{
		if (\headers_sent())
		{
			return $this;
		}

		$length = \strlen($this->getContent());
		var_dump($length); die;
		if ($length > 0)
		{
			$this->headers->set('content-length', $length);
		}

		return parent::sendHeaders();
	}
}
