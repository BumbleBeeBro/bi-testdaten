<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Store;
use \App\Mitarbeiter;
use \App\Produkt;
use Illuminate\Support\Facades\Log;

class MitarbeiterController extends Controller
{

	public function products_sold($id) {

		$products_sold = Mitarbeiter::where('id', $id)->get()->first()->transactions()->count();
		//$products_sold = Mitarbeiter::where('id', $id)->get()->first()->products_sold();

		return view('dwh-operations', compact('products_sold'));
	}

        public static function create_api(){

        $name = request('name');
    	$firstName = request('firstName');

    	$faker = \Faker\Factory::create();

    	$create_array = null;

		if ($name) {
			$create_array['name'] = $faker->lastName;
		}

		if ($firstName) {
			$create_array['firstName'] = $faker->firstName($gender = null);
		}

		//zufällige zuweisung zu Store
		$create_array['store_id'] = $faker->numberBetween($min = 1, $max = Store::orderByDesc('id')->get()->first()->id);

		$mitarbeiter = Mitarbeiter::create($create_array);

		return $mitarbeiter;
	}
}
