<?php

namespace bi_testdaten;

use Illuminate\Database\Eloquent\Model;
use \bi_testdaten\Transaktion;
use \bi_testdaten\Hersteller;

/**
 * Verwaltet die Erstellung eines Produkts.
 */
class Produkt extends Model
{
   
	//Erstellbare Attribute.   
    protected $fillable = ['name', 'price', 'producer', 'description', 'tax'];

    /**
    * Erstellung eines Produkts mit angegbenen Attributen.
    * @param  Array of Boolean $product_input -> Zu erstellende Attribute.
    * @return String, Logoutput
    */
    public function generate($product_input){

    	$faker = \Faker\Factory::create();

    	//Namen setzen.
		if ($product_input['p_name']) {

			$this->name = $faker->word;

		}

		//Preis setzen.
		if ($product_input['p_price']) {

			$this->price = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000);
		}

		//Produzent setzen.
		if ($product_input['p_producer']) {

			$this->producer = Hersteller::inRandomOrder()->get()->first()->id;
		}

		//Beschreibung zufaellig erstellen.
		if ($product_input['p_description']) {

			$this->description = $faker->text($maxNbChars = 200);
		}

		//Steuer setzen.
		if ($product_input['p_tax']) {

			$this->tax = $faker->randomElement([0.07,0.19]);
		}

		//in DB speichern.
		$this->save();

		return 	' Produkt: ' . $this->id . ' erstellt';
	}

	/**
	 * Gibt die Transaktion dieses Produkts(this) wieder.
	 * @return Transaktion
	 */
	public function transactions() {
		//Gibt die Funktion auch mehrere Transaktionen wieder?
    	return $this->hasMany('\bi_testdaten\Transaktionsposition', 'produkt_id')->get();
    }



}
