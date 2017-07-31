<?php

namespace bi_testdaten\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
	/**
	 * Gibt die Eingabemaske zurück.
	 * @return home view
	 */
	public function home() {
		chdir('/var/www/html/bi-testdaten/vendor/fzaninotto/faker/src/Faker/Provider/');
		$languages = array_filter(glob('*'), 'is_dir');

		return view('home', compact('languages'));
	}

	/**
	 * Gibt das Impressum zurück.
	 * @return imprint view
	 */
	public function imprint() {

		return view('imprint');
	}

	/**
	 * Gibt die Datenschutzinformationen zurück.
	 * @return privacy view
	 */
	public function privacy() {

		return view('privacy');
	}

}
