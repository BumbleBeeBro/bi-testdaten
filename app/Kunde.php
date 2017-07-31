<?php

namespace bi_testdaten;

use Illuminate\Database\Eloquent\Model;

/**
 * Verwaltet die Erstellung von Kunden.
 */
class Kunde extends Model
{
	//Erstellbare Attribute.
	protected $fillable = ['name', 'firstName', 'address', 'email', 'phoneNumber', 'birthDate'];

	/** 
	 * Erstellung eines Kunden mit ausgewählten Attributen.
	 * @param  Array of Boolean $customer_input -> Array der zu erstellenden Attribute.
	 * @return String, Logoutput
	 */
	public function generate($customer_input) {

        
    	//Erstellung der Faker-Factory.
		$faker = \Faker\Factory::create();

		/*$create_array = null;*/

		//Abfrage, ob Attribut verwendet werden soll. Falls ja, zufaellig erstellen.
		if ($customer_input['k_name']) {
			$this->name = $faker->lastName;
		}

		//Vornamen setzen.
		if ($customer_input['k_firstName']) {
			$this->firstName = $faker->firstName(null);
		}

		//Adresse setzen.
		if ($customer_input['k_address']) {
			$this->address = $faker->address;
		}

		//E-Mail setzen.
		if ($customer_input['k_email']) {
			$this->email = $faker->email;
		}

		//Telefonnummer setzen.
		if ($customer_input['k_phoneNumber']) {
			$this->phoneNumber = $faker->phoneNumber;
		}

		//Geburtsdatum setzen. Das erstellte Datum liegt in Bezug auf das aktuelle Datem zwischen 80 und 18 Jahre zurück.
		if ($customer_input['k_birthDate']) {
			$this->birthDate = $faker->dateTimeBetween('-80 years', '-18Years')->format('Y-m-d');
		}

		//in DB speichern.
		$this->save();

		return '		Kunde: ' . $this->id . ' erstellt';
    }
	
}
