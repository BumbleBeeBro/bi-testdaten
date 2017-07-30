<?php

namespace bi_testdaten\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
	public function home() {
		chdir('/var/www/html/bi-testdaten/vendor/fzaninotto/faker/src/Faker/Provider/');
		$languages = array_filter(glob('*'), 'is_dir');

		return view('home', compact('languages'));
	}

}
