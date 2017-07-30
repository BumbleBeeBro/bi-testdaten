<?php

namespace bi_testdaten;

use Illuminate\Database\Eloquent\Model;

class Hersteller extends Model
{
	//Erstellbare Attribute.   
    protected $fillable = ['name', 'email', 'address'];

    public function generate($producer_input){

    	$faker = \Faker\Factory::create($producer_input['language']);

    	//Namen setzen.
		if ($producer_input['h_name']) {
			$this->name = $faker->company;
		}

		if ($producer_input['h_address']) {
			$this->address = $faker->address;
		}

		if ($producer_input['h_email']) {
			$this->email = $faker->email;
		}

		//in DB speichern.
		$this->save();

		return 	' Hersteller: ' . $this->id . ' erstellt';

	}
}

