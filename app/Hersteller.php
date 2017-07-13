<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hersteller extends Model
{
	//Erstellbare Attribute.   
    protected $fillable = ['name', 'email', 'adress'];

    public function generate($producer_input){

    	$faker = \Faker\Factory::create();

    	//Namen setzen.
		if ($producer_input['h_name']) {
			$this->name = $faker->word;
		}

		if ($producer_input['h_adress']) {
			$this->adress = $faker->address;
		}

		if ($producer_input['h_email']) {
			$this->email = $faker->email;
		}

		//in DB speichern.
		$this->save();

		return 	'Hersteller: ' . $this->id . ' erstellt';

	}
}

