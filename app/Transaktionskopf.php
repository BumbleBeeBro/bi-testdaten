<?php

namespace App;

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

        $this->mitarbeiter_id = $store->mitarbeiter()->inRandomOrder()->get()->first()->id;

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
    	return $this->belongsTo('\App\Mitarbeiter', 'mitarbeiter_id')->get()->first();
    }

    /**
     * @return Store, welcher von der Transaktion verwendet wird.
     */
    public function store() {
    	return$this->hasOne('\App\Store', 'store_id')->get()->first();
    }

    /**
     * @return Kunde, welcher von der Transaktion verwendet wird.
     */
    public function customer() {
    	return $this->hasOne('\App\Kunde', 'kunde_id')->get()->first();
    }
}
