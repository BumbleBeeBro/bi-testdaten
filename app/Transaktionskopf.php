<?php

namespace bi_testdaten;

use Illuminate\Database\Eloquent\Model;

class Transaktionskopf extends Model
{
    protected $fillable = ['kunde_id', 'store_id', 'mitarbeiter_id', 'shipping', 'paymentMethod', 'date'];    

    public function generate($transactionHead_input) {

        //dd($transactionHead_input);

        $faker = \Faker\Factory::create();

        if ($transactionHead_input['t_shipping']) {
                $this->shipping = $faker->randomElement(['Abholung', 'Lieferung']);
        }

        if ($transactionHead_input['t_paymentMethod']) {
            $this->paymentMethod = $faker->randomElement(['Barzahlung', 'Kreditkartenzahlung', 'Onlinezahlung', 'Rechnungszahlung']);
        }

        //letzer erstellter Kunde
        $this->kunde_id = Kunde::orderBy('id', 'desc')->get()->first()->id;
    
        $store = Store::inRandomOrder()->get()->first();

        $this->store_id = $store->id;

        if ($transactionHead_input['s_employees']) {
            $this->mitarbeiter_id = $store->mitarbeiter()->inRandomOrder()->get()->first()->id;
        }
        else{
            $this->mitarbeiter_id = null;
        }

        //es können unix zeiten übergeben werden 
        //https://stackoverflow.com/questions/31076792/how-to-get-future-date-in-faker
        $this->date = $faker->dateTimeBetween($transactionHead_input['t_min_date'], $transactionHead_input['t_max_date'])->format('Y-m-d H:i:s');

        $this->save();

        return '    Transaktionskopf ' . $this->id . ' erstellt';
    }


    /**
     * @return Mitarbeiter, welcher von der Transaktion verwendet wird.
     */
    public function employee() {
    	return $this->belongsTo('\bi_testdaten\Mitarbeiter', 'mitarbeiter_id')->get()->first();
    }

    /**
     * @return Store, welcher von der Transaktion verwendet wird.
     */
    public function store() {
    	return $this->hasOne('\bi_testdaten\Store', 'store_id')->get()->first();
    }

    /**
     * @return Kunde, welcher von der Transaktion verwendet wird.
     */
    public function customer() {
    	return $this->hasOne('\bi_testdaten\Kunde', 'kunde_id')->get()->first();
    }

    public function transactionbodies() {
        return $this->hasOne('\bi_testdaten\Transaktionsposition', 'transaktionskopf_id')->get();
    }
}
