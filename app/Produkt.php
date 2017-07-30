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
    generate funktion
    product_input: Speichert welche ausprägungen generiert werden sollen. zusätzlich werden eigenene datensets übergeben wenn diese exitieren. diese müssen in folgender weise übergeben werden
    product_input['p_name_custom'] ein string der den Namen des Produkts angibt
    $product_input['p_price_custom_min'], $product_input['p_price_custom_max'] integer beide oder keiner der beiden variablen müssen angegeben werden.
    $product_input['p_prducer_custom'] array mit strings von Herstellern
    $product_input['p_tax_custom'] array mit float Werten für Steuersätze.
    Wenn die custom Optionen nicht angegeben werden, werden die Attribute mit zufälligen werten gefüllt. 
    */
   /**
    * Erstellung eines Produkts mit angegbenen Attributen.
    * @param  Array of Boolean $product_input -> Zu erstellende Attribute.
    * @return Logoutput.
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

		

		/*//http://php.net/manual/de/function.memory-get-usage.php
		//Log::info(memory_get_usage());*/

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
