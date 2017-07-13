<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Store;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
	/**
	 * NICHT VERWENDET
	 * Store erstellen. Die zu verwendenden Parameter werden ueber API abgefragt. Die Attribute werden zufaellig mit Faker-Framework erstellt.
	 * @return Store
	 */
    public function create_api() {

    	//Zu erstellende Parameter abfragen.
    	$adress = request('adress');
    	$phoneNumber = request('phoneNumber');
    	$email = request('email');
    	$website = request('website');

    	//Faker-Factory erstellen.
    	$faker = \Faker\Factory::create();

    	//Array fuer Attribute 
    	$create_array = null;

    	//Abfragen, welche Parameter verwendet werden sollen.
		if ($adress) {
			$create_array['adress'] = $faker->address;
		}

		if ($phoneNumber) {
			$create_array['phoneNumber'] = $faker->phoneNumber;
		}

		if ($email) {
			$create_array['email'] = $faker->email;
		}

		if ($website) {
			 $create_array['website'] = $faker->domainName;
		}
		
		//Store mit Attributen erstellen.
		$store = Store::create($create_array);

		return $store;
	}
}
