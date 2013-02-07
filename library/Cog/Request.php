<?php

namespace Cog;

/**
 * The HTTP Request
 *
 * @package  Cog
 */
class Request extends AbstractMessage implements HTTP\Request
{
	/**
	 * Creates a new Request from the PHP Global variables.
	 *
	 * @return \Cog\Request
	 */
	public static function createFromGlobals()
	{
		return new static(array(
			'query' => $_GET,
			'post' => $_POST,
			'headers' => $_SERVER,
			'cookies' => $_COOKIE,
			'files' => $_FILES,
			'body' => \file_get_contents("php://input")
		));
	}

	/**
	 * @var \Cog\Hash  Query string variables
	 */
	private $query;

	/**
	 * @var \Cog\Hash  Post variables
	 */
	private $post;

	/**
	 * @var \Cog\Hash  Cookies
	 */
	private $cookies;

	/**
	 * @var \Cog\Hash  File upload data
	 */
	private $files;

	/**
	 * @var string     The http protocol scheme (https?)
	 */
	private $scheme;

	/**
	 * Creates a new HTTP Request.
	 *
	 * Here are the properties that can be set.
	 *
	 * Key     | Description                 | Type
	 * --------|-----------------------------|-------
	 * query   | Query data                  | array
	 * post    | Post data                   | array
	 * headers | HTTP Request headers        | array
	 * cookies | Cookies                     | array
	 * files   | File Upload data            | array
	 * body    | The raw http request body   | string
	 *
	 * @param array $data  The request parameters
	 */
	public function __construct(array $data = array())
	{
		$default = array(
			'query' => array(),
			'post' => array(),
			'headers' => array(),
			'cookies' => array(),
			'files' => array()
		);

		$data = array_merge($default, $data);
		foreach (\array_keys($default) as $key)
		{
			$this->{$key} = new \Cog\Hash($data[$key]);
		}

		$body = "";
		if (\array_key_exists('body', $data))
		{
			$body = $data['body'];
			unset($data['body']);
		}
		$this->setBody($body);

		$this->setScheme();
	}

	/**
	 * Internal function to get the value of a Hash.
	 *
	 * @param  string $name    The hash to search
	 * @param  string $key     The property to find | if null then the full array
	 * @param  mixed  $default The default value if the property isn't found
	 * @return mixed           Full data array or the property|default value
	 */
	private function getValue($name, $key, $default)
	{
		if ($key === null)
		{
			return $this->{$name}->toArray();
		}

		return $this->{$name}->get($key, $default);
	}

	/**
	 * Internal function to get the value of a Hash.
	 *
	 * @param  string $name    The hash to search
	 * @param  string $key     The property to find | if null then the full array
	 * @param  mixed  $default The default value if the property isn't found
	 * @return mixed           Full data array or the property|default value
	 */
	private function setValue($name, $key, $value)
	{
		if ( ! \is_array($key))
		{
			$key = array($key => $value);
		}

		$this->{$name}->setArray($key);
	}

	/**
	 * @see #getValue
	 */
	public function getQuery($name = null, $default = null)
	{
		return $this->getValue('query', $name, $default);
	}

	/**
	 * @see #setValue
	 */
	public function setQuery($name, $value = null)
	{
		$this->setValue('query', $name, $value);
		return $this;
	}

	/**
	 * @see #getValue
	 */
	public function getPost($name = null, $default = null)
	{
		return $this->getValue('post', $name, $default);
	}

	/**
	 * @see #setValue
	 */
	public function setPost($name, $value = null)
	{
		$this->setValue('post', $name, $value);
		return $this;
	}

	/**
	 * @see #getValue
	 */
	public function getCookies($name = null, $default = null)
	{
		return $this->getValue('cookies', $name, $default);
	}

	/**
	 * @see #setValue
	 */
	public function setCookies($name, $value = null)
	{
		$this->setValue('cookies', $name, $value);
		return $this;
	}

	/**
	 * @see #getValue
	 */
	public function getFiles($name = null, $default = null)
	{
		return $this->getValue('files', $name, $default);
	}

	/**
	 * @see #setValue
	 */
	public function setFiles($name, $value = null)
	{
		$this->setValue('files', $name, $value);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType()
	{
		return $this->headers->get('HTTP_ACCEPT', '');
	}

	/**
	 * @return array
	 */
	public function getMediaType()
	{
		list($type) = \explode(";", $this->getContentType());
		return \explode(',', $type);
	}


	/**
	 * @return string
	 */
	public function getScriptName()
	{
		$name = $this->getHeader('SCRIPT_NAME', '');
		if ($name !== '')
		{
			$name = '/' . \ltrim($name, '/');
		}

		return $name;
	}

	/**
	 * @return string
	 */
	public function getPathInfo()
	{
		$path = $this->getHeader('PATH_INFO', '');
		if ($path !== '')
		{
			$path = '/' . \ltrim($path, '/');
		}

		return $path;
	}

	/**
	 * @return int
	 */
	public function getContentLength()
	{
		return $this->getHeader('SCRIPT_NAME', 0);
	}

	/**
	 * @return array
	 */
	public function getMediaTypeParams()
	{
		$media = \explode(';', $this->getContentType());
		\array_shift($media);

		$params = array();
		foreach ($media as $item)
		{
			list($key, $value) = \explode('=', $item);

			if (\array_key_exists($key, $params))
			{
				if ( ! \is_array($params[$key]))
				{
					$params[$key] = array($params[$key]);
				}

				$params[$key][] = $value;
			}
			else
			{
				$params[$key] = $value;
			}
		}

		return $params;
	}

	/**
	 * @return string|null
	 */
	public function getCharset()
	{
		$charset = $this->headers->get('HTTP_ACCEPT_CHARSET', null);

		if ($charset === null)
		{
			$params = $this->getMediaTypeParams();
			if (\array_key_exists('charset', $params))
			{
				$charset = $params['charset'];
			}
		}

		return $charset;
	}

	/**
	 * @return string
	 */
	public function getScheme()
	{
		return $this->scheme;
	}

	public function setScheme()
	{
		$scheme = 'http';
		$https = $this->headers->get('HTTPS');
		if ($https !== null && $https !== 'off')
		{
			$scheme .= "s";
		}

		$this->scheme = $scheme;
	}

	/**
	 * @return int
	 */
	public function getPort()
	{
		return (int) $this->getHeader('SERVER_PORT', 80);
	}

	/**
	 * @return string
	 */
	public function getHost()
	{
		return $this->getHeader('HTTP_HOST', 'localhost');
	}

	/**
	 * @return string
	 */
	public function getReferrer()
	{
		return $this->getHeader('HTTP_REFERER', '');
	}

	/**
	 * @return string
	 */
	public function getUserAgent()
	{
		return $this->getHeader('HTTP_USER_AGENT', '');
	}

	/**
	 * @return string
	 */
	public function getBaseUrl()
	{
		$url = $this->getScheme().'://'.$this->getHost();

		if ( ! in_array($this->getPort(), array(80, 443)))
		{
			$url .= ':'.$this->getPort();
		}

		return $url;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->getBaseUrl() . $this->getFullPath();
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->getScriptName() . $this->getPathInfo();
	}

	/**
	 * @return string
	 */
	public function getFullPath()
	{
		$path = $this->getPath();
		$query = $this->getQuery();

		if ( ! empty($query))
		{
			$path .= "?".\http_build_query($query);
		}

		return $path;
	}

	/**
	 * @return string
	 */
	public function getAcceptEncoding()
	{
		$encoding = \explode(',', $this->getHeader('HTTP_ACCEPT_ENCODING', ''));
		return array_map('trim', $encoding);
	}

	/**
	 * @return boolean
	 */
	public function isXHR()
	{
		$header = $this->getHeader('HTTP_X_REQUESTED_WITH', false);
		return $header === "XMLHttpRequest";
	}

	/**
	 * @return boolean
	 */
	public function isSSL()
	{
		return $this->getScheme() === 'https';
	}

	/**
	 * @return boolean
	 */
	public function isDelete()
	{
		return $this->getMethod() === "DELETE";
	}

	/**
	 * @return boolean
	 */
	public function isGet()
	{
		return $this->getMethod() === "GET";
	}

	/**
	 * @return boolean
	 */
	public function isPost()
	{
		return $this->getMethod() === "POST";
	}

	/**
	 * @return boolean
	 */
	public function isPut()
	{
		return $this->getMethod() === "PUT";
	}

/** =======================
    \Cog\HTTP\Message
    ======================= */

	/**
	 * {@inheritDoc}
	 */
	public function __toString()
	{
		return ""; // Fix this....
	}

/** =======================
    \Cog\HTTP\Request
    ======================= */

	/**
	 * {@inheritDoc}
	 */
	public function getMethod()
	{
		return $this->headers->get('REQUEST_METHOD', 'GET');
	}

	/**
	 * {@inheritDoc}
	 */
	public function setMethod($method)
	{
		$this->headers->set('REQUEST_METHODD', $method);
		return $this;
	}

}
