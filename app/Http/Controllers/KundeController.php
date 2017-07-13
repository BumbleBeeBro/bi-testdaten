<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Kunde;
use Illuminate\Support\Facades\Log;

//NICHT VERWENDET!
class KundeController extends Controller
{

	/**
	 * NICHT VERWENDET
	 * Kunde erstellen. Die zu verwendenden Parameter werden ueber API abgefragt. Die Attribute werden zufaellig mit Faker-Framework erstellt.
	 * @return Kunde
	 */
	public function create_api() {

		//Parameter abfragen.
        $name = request('name'); 
        $firstName = request('firstName'); 
        $adress = request('adress'); 
        $email = request('email'); 
        $phoneNumber = request('phoneNumber'); 
        $birthDate = request('birthDate');
        
    	//Faker-Factory erstellen.
		$faker = \Faker\Factory::create();

		//Array fuer Attribute 
		$create_array = null;

		
		//Abfragen, welche Parameter verwendet werden sollen.
		if ($name) {
			$create_array['name'] = $faker->lastName;
		}

		if ($firstName) {
			$create_array['firstName'] = $faker->firstName(null);
		}

		if ($adress) {
			$create_array['adress'] = $faker->address;
		}

		if ($email) {
			$create_array['email'] = $faker->email;
		}

		if ($phoneNumber) {
			$create_array['phoneNumber'] = $faker->phoneNumber;
		}

		if ($birthDate) {
			$create_array['birthDate'] = $faker->dateTimeBetween('-80 years', '-18Years')->format('Y-m-d');
		}

		//Kunde mit Attributen erstellen.
		$kunde = Kunde::create($create_array);

		return $kunde;
    }
        

}
