<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class IndexController extends Controller {
	/**
	 * @Get("/")
	 */
	public function angularPages()
	{
		return file_get_contents(__DIR__ . '/../../../public/app/index.html');
	}
}
