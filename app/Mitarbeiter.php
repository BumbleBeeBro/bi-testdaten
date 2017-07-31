<?php

namespace bi_testdaten;

use Illuminate\Database\Eloquent\Model;
use \bi_testdaten\Store;

/**
 * Verwaltet die Generierung der Mitarbeiter entsprechend den ausgewählten Attributen.
 */
class Mitarbeiter extends Model
{

	//Befüllbare Attribute.
    protected $fillable = ['name', 'firstName', 'store_id'];

    /**
     * @param  Array of Boolean $employee_input -> Zu erstellende Attribute.
     * @return String, Logoutput
     */
    public function generate($employee_input, $i){

    	//Faker-Factory erstellen.
    	$faker = \Faker\Factory::create();

    	/*$create_array = null;*/

    	//Nachnamen setzen.
		if ($employee_input['m_name']) {
			$this->name = $faker->lastName;
		}

		//Vornamen setzen.
		if ($employee_input['m_firstName']) {
			$this->firstName = $faker->firstName($gender = null);
		}

		//Ermittlere die ID des zuletzt hinzugefügten Stores.
		$max_store_id = Store::orderByDesc('id')->get()->first()->id;

		//Prüfen, ob jeder Store bereits belegt ist.
		if ($i > $max_store_id) {

			//Weise dem zu erstellenden Mitarbeiter eine zufällige Store-ID zu.
			$this->store_id = $faker->numberBetween($min = 1, $max = $max_store_id);

		} else{

			//Weise dem zus erstellenden Mitarbeiter die ID des zuletzt erstellten Stores zu.
			$this->store_id = $i;

		}

		//Ergebnisse in DB speichern.
		$this->save();

		return ' Mitarbeiter: ' . $this->id . ' erstellt';
	}

    /** 
     * Gibt die Transaktionsköpfe wieder, an denen der Mitarbeiter beteiligt war.
     * @return Transaktionsköpfe des Mitarbeiters.
     */
    public function transactions() {
    	return $this->hasMany('\bi_testdaten\Transaktionskopf', 'mitarbeiter_id')->get();
    }
}
