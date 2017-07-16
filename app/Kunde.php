<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kunde extends Model
{
	//Erstellbare Attribute.
	protected $fillable = ['name', 'firstName', 'address', 'email', 'phoneNumber', 'birthDate'];

	/** 
	 * @param  Array der zu erstellenden Attribute.
	 * @return Model, welches in Datenbank gespeichert wird.
	 */
	public function generate($customer_input) {

        
    	// use the factory to create a Faker\Generator instance
		$faker = \Faker\Factory::create();

		$create_array = null;

		//Abfrage, ob Attribut verwendet werden soll. Falls ja, zufaellig erstellen.
		if ($customer_input['k_name']) {
			$this->name = $faker->lastName;
		}

		if ($customer_input['k_firstName']) {
			$this->firstName = $faker->firstName(null);
		}

		if ($customer_input['k_address']) {
			$this->address = $faker->address;
		}

		if ($customer_input['k_email']) {
			$this->email = $faker->email;
		}

		if ($customer_input['k_phoneNumber']) {
			$this->phoneNumber = $faker->phoneNumber;
		}

		if ($customer_input['k_birthDate']) {
			$this->birthDate = $faker->dateTimeBetween('-80 years', '-18Years')->format('Y-m-d');
		}

		//in DB speichern.
		$this->save();

		return '		Kunde: ' . $this->id . ' erstellt';
    }
	
}
