<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Store;

class Mitarbeiter extends Model
{

	//Muss "store_id" hier nicht rausgenommen werden?
    protected $fillable = ['name', 'firstName', 'store_id'];

    public function generate($employee_input){

    	$faker = \Faker\Factory::create();

    	$create_array = null;

		if ($employee_input['m_name']) {
			$this->name = $faker->lastName;
		}

		if ($employee_input['m_firstName']) {
			$this->firstName = $faker->firstName($gender = null);
		}


		//Es muss gesichert werden, dass kein Store ohne Mitarbeiter existiert.

		//$this->store_id = $faker->numberBetween($min = 1, $max = Store::orderByDesc('id')->get()->first()->id);

		$max_store_id = Store::orderByDesc('id')->get()->first()->id;

		if ($this->id > $max_store_id) {

			$this->store_id = $faker->numberBetween($min = 1, $max = $max_store_id);

		}
		else{

			$this->store_id = $this->id;

		}

		$this->save();

		return ' Mitarbeiter: ' . $this->id . ' erstellt';
	}


    public function products_sold() {    	
    	return $this->transactions()->count();
    }


    public function transactions() {

    	return $this->hasMany('\App\Transaktion', 'mitarbeiter_id')->get();
    	//return Transaktion::where('mitarbeiter_id', $this->id)->get();


    }
}
