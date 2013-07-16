<?php

namespace Api;

/**
 * Http exceptions.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class HttpErrorException extends \HttpException
{
	protected $code = 500;
	
	public function response()
	{
		if ($this instanceof HttpBadRequestException) {
			$this->message = 'Missing or Invalid Parameter(s): ' . $this->getMessage();
		}
		
		$response = null;
		if ($this->getMessage()) {
			$data = array('message' => $this->getMessage());
			$response = \Format::forge($data)->to_json();
		}
		
		return new \Response($response, $this->getCode());
	}
}

class HttpBadRequestException extends HttpErrorException
{
	protected $code = 400;
}

class HttpNotFoundException extends HttpErrorException
{
	protected $code = 404;
}

class HttpServerErrorException extends HttpErrorException
{
	protected $code = 500;
}
