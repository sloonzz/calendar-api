<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class ApiResponse extends Response {
	public function __construct($content, $status = 'success', $code = 200, $headers = [])
	{
		return parent::__construct(json_encode([
			'data' => $content,
			'status' => $status,
			'code' => $code
		]), $code, $headers);
	}
}