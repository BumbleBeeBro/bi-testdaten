<?php

namespace bi_testdaten;

use Illuminate\Database\Eloquent\Model;

class Transaktionskopf extends Model
{
    //Befüllbare Attribute.
    protected $fillable = ['kunde_id', 'store_id', 'mitarbeiter_id', 'shipping', 'paymentMethod', 'date'];    

    /**
     * Generiert einen Transaktionskopf mit zufaelligen Parametern.
     * @param  Array of Boolean $transactionHead_input -> Boolesches Array, welches die zu erstellenden Parameter angibt.
     * @return String, Logoutput
     */
    public function generate($transactionHead_input) {

        //dd($transactionHead_input);

        $faker = \Faker\Factory::create();

        //setze shipping
        if ($transactionHead_input['t_shipping']) {

                $this->shipping = $faker->randomElement(['Abholung', 'Lieferung']);
        }

        //setze Bezahlmethode
        if ($transactionHead_input['t_paymentMethod']) {

            $this->paymentMethod = $faker->randomElement(['Barzahlung', 'Kreditkartenzahlung', 'Onlinezahlung', 'Rechnungszahlung']);
        }

        //letzer erstellter Kunde
        $this->kunde_id = Kunde::orderBy('id', 'desc')->get()->first()->id;
        
        //wähle einen zufälligen Store
        $store = Store::inRandomOrder()->get()->first();

        $this->store_id = $store->id;

        //wähle einen dort arbeitenden Mitarbeiter
        if ($transactionHead_input['s_employees']) {
            $this->mitarbeiter_id = $store->mitarbeiter()->inRandomOrder()->get()->first()->id;
        }
        else{
            $this->mitarbeiter_id = null;
        }

        //wähle ein Transaktionsdatum
        $this->date = $faker->dateTimeBetween($transactionHead_input['t_min_date'], $transactionHead_input['t_max_date'])->format('Y-m-d H:i:s');

        $this->save();

        return '    Transaktionskopf ' . $this->id . ' erstellt';
    }


    /**
     * Gibt den Mitarbeiter der Transaktion zurück.
     * @return Mitarbeiter, welcher von der Transaktion verwendet wird.
     */
    public function employee() {
    	return $this->belongsTo('\bi_testdaten\Mitarbeiter', 'mitarbeiter_id')->get()->first();
    }

    /**
     * Gibt den Store der Transaktion zurück.
     * @return Store, welcher von der Transaktion verwendet wird.
     */
    public function store() {
    	return $this->hasOne('\bi_testdaten\Store', 'store_id')->get()->first();
    }

    /**
     * Gibt den Kunden der Transaktion zurück.
     * @return Kunde, welcher von der Transaktion verwendet wird.
     */
    public function customer() {
    	return $this->hasOne('\bi_testdaten\Kunde', 'kunde_id')->get()->first();
    }

    /**
     * gibt die zugehörigen Transakionspositionen zurück.
     * @return Eloquent-Collection Transaktionsposition
     */
    public function transactionbodies() {
        return $this->hasOne('\bi_testdaten\Transaktionsposition', 'transaktionskopf_id')->get();
    }
}
