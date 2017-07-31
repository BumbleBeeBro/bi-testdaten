<?php

namespace bi_testdaten;

use Illuminate\Database\Eloquent\Model;

/**
 * Verwaltet die Ertellung eines Stores.
 */
class Store extends Model
{
	//Befüllbare Attribute.
    protected $fillable = ['address', 'phoneNumber','email', 'website'];

    /**
     * Generiert einen Store mit zufaelligen Parametern.
     * @param  Array of Boolean $store_input -> Boolesches Array, welches die zu erstellenden Parameter angibt.
     * @return String, Logoutput
     */
    public  function generate($store_input) {

    	$faker = \Faker\Factory::create();

    	//Adresse setzen.
		if ($store_input['s_address']) {
			$this->address = $faker->address;
		}

		//Telefonnummer setzen.
		if ($store_input['s_phoneNumber']) {
			$this->phoneNumber = $faker->phoneNumber;
		}

		// E-Mail setzen.
		if ($store_input['s_email']) {
			$this->email = $faker->email;
		}

		//Website setzen.
		if ($store_input['s_website']) {
			 $this->website = $faker->domainName;
		}
		
		//Speichert in DB.
		$this->save();

		return ' Store: ' . $this->id . ' erstellt';
	}

	/**
	 * Gibt die Mitarbeiter eines Stores aus.
	 * @return Mitarbeiter des Store.
	 */
	public function mitarbeiter() {
		return $this->hasMany('\bi_testdaten\Mitarbeiter', 'store_id');
	}
}
