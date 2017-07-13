<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['adress', 'phoneNumber','email', 'website'];

    /**
     * Generiert einen Store mit zufaelligen Parametern.
     * @param  Boolesches Array, welches die zu erstellenden Parameter angibt.
     * @return String, Erstellnachricht.
     */
    public  function generate($store_input) {

    	$faker = \Faker\Factory::create();

    	$create_array = null;

		if ($store_input['s_adress']) {
			$this->adress = $faker->address;
		}

		if ($store_input['s_phoneNumber']) {
			$this->phoneNumber = $faker->phoneNumber;
		}

		if ($store_input['s_email']) {
			$this->email = $faker->email;
		}

		if ($store_input['s_website']) {
			 $this->website = $faker->domainName;
		}
		
		//Speichert in DB.
		$this->save();

		return ' Store: ' . $this->id . ' created';
	}
}
