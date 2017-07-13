<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Produkt;
use Illuminate\Support\Facades\Log;

class ProduktController extends Controller
{

	/**
	 * Ermittle die Verkaufe eines bestimmten Produktes.
	 * @param  Produkt, von welchem die Verkaeufe ermittelt werden sollen.
	 * @return View, mit uebergebenen Verkaeufen.
	 */
	public function total_sales($id) {

	$product = Produkt::where('id', $id)->get()->first();

		$total_sales = $product->total_sales();

		return view('dwh-operations', compact('total_sales'));
	}

	/**
	 * NICHT VERWENDET!
	 * Erstelle Produkt mit zufaelligen Werten.
	 * @return Produkt
	 */
    public static function create_api(){

        $name = request('name');
    	$price = request('price');
    	$producer = request('producer');
		$description = request('description');
		$tax = request('tax');

    	$faker = \Faker\Factory::create();

    	$create_array = null;

		if ($name) {
			$create_array['name'] = $faker->word;
		}

		if ($price) {
			$create_array['price'] = $faker->randomFloat($nbMaxDecimals = 2 /*Zahlen nach dem Komma?*/, $min = 0, $max = 1000);
		}

		if ($producer) {
			$create_array['producer'] = $faker->company;
		}

		if ($description) {
			$create_array['description'] = $faker->realText($maxNbChars = 200);
		}


		if ($tax) {
			$create_array['tax'] = $faker->randomElement($tax_array = array(0.07,0.19));
		}

		$produkt = Produkt::create($create_array);	

		return 	$produkt;
	}
}
