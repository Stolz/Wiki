<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Response;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported to log.
	 *
	 * @var array
	 */
	protected $dontReport = [
		HttpException::class,
	];

	protected $httpCodes = [
		0   => 'Unknown error',
		// [Informational 1xx]
		100 => 'Continue',
		101 => 'Switching Protocols',
		// [Successful 2xx]
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		// [Redirection 3xx]
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => '(Unused)',
		307 => 'Temporary Redirect',
		// [Client Error 4xx]
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		// [Server Error 5xx]
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 *
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		// If debug is enabled in local environment dump stack trace
		if(config('app.debug') and app()->environment('local'))
			return (class_exists('Whoops\\Run')) ? $this->whoops($e) : parent::render($request, $e);

		// HTTP exceptions are are normally intentionally thrown and its safe to show their message
		if($this->isHttpException($e))
		{
			$code = $e->getStatusCode();
			$message = $e->getMessage();

			if(empty($message))
				$message = (isset($this->httpCodes[$code])) ? $this->httpCodes[$code] : $this->httpCodes[500];
		}
		// Other exceptions are usually unexpected errors and is best not to show their message but instead disguise them as error 500.
		else
		{
			$code = $e->getCode();

			if( ! isset($this->httpCodes[$code]))
				$code = 500;

			$message = $this->httpCodes[$code];
		}

		// If a custom view exist use it, otherwise use generic error page
		$view = (view()->exists("errors/$code")) ? "errors/$code" : 'layouts/error';

		// Data for the view
		$data = [
			'title' => $message,
			'code'  => $code
		];

		return Response::view($view, $data, $code);
	}

	/**
	 * Render an exception into an HTTP response using Whoops.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function whoops(Exception $e)
	{
		$whoops = new \Whoops\Run;
		$handler = new \Whoops\Handler\PrettyPageHandler;
		$handler->setEditor('sublime');
		$whoops->pushHandler($handler);

		return response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
	}
}
