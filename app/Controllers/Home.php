<?php namespace App\Controllers;

class Home extends BaseController
{
	// landing page afetr login
	public function index()
	{
		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
