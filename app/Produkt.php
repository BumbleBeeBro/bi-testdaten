<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Transaktion;
use \App\Hersteller;

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
    public function generate($product_input){

    	$faker = \Faker\Factory::create();

    	//Namen setzen.
		if ($product_input['p_name']) {

			$this->name = $faker->word;

		}

		//kann man dann hier nicht auch einen selbst gesetzten Preis nehmen?
		//zufaelligen preis ermitteln. Min & Max kann selbst gestzt werden.
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

		

		//http://php.net/manual/de/function.memory-get-usage.php
		//Log::info(memory_get_usage());

		return 	' Produkt: ' . $this->id . ' erstellt';

	}

	//foreach geht glaube ich nicht auf collections.
	/**
	 * Berechnet die gesamten Verkaeufe ueber alle Transaktionen des Produkts.
	 * @return Integer
	 */
	public function total_sales() {
		$total_sales = 0;

		foreach ($this->transactions() as $transaction) {

			$total_sales += $transaction->net_price;
		}
		return $total_sales;
	}

	/**
	 * Gibt die Transaktion dieses Produkts(this) wieder.
	 * @return Transaktion
	 */
	public function transactions() {
		//Gibt die Funktion auch mehrere Transaktionen wieder?
    	return Transaktion::where('produkt_id', $this->id)->get();
    }



}
