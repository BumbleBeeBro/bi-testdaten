<?php

namespace bi_testdaten;

use Illuminate\Database\Eloquent\Model;
use \bi_testdaten\Transaktionskopf;

class Transaktionsposition extends Model
{
    protected $fillable = ['produkt_id', 'transaktionskopf_id', 'amount' ,'discount', 'net_price'];  

    public function generate($transactionPosition_input) {

        $faker = \Faker\Factory::create();

        if ($transactionPosition_input['t_number']) {
            $this->amount = $faker->numberBetween($min = 1, $max = 10);
        } else {
            $this->amount = 1;
        }

        if ($transactionPosition_input['t_discount']) {
            $this->discount = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 0.3);
        }

        $this->produkt_id = Produkt::inRandomOrder()->get()->first()->id;

        //letzter erstellter Transaktionskopf
        $this->transaktionskopf_id = Transaktionskopf::orderBy('id', 'desc')->get()->first()->id;

        $this->save();

        return 'Transaktionsposition ' . $this->id . ' erstellt';
    }

    public function calculate_price() {

    	//muss nicht mit einem try und catch statement umklammert werden , da null Einträge für PHP bei Rechenoperationen als 0 angesehen werden
        $price = $this->product()->price;
    	$tax = $this->product()->tax;
    	$discount = $this->discount;
    	$amount = $this->amount;

    	$this->net_price = ($price * $discount) * (1 + $tax) * $amount; 

    	$this->save();

    }

    //https://laravel.com/docs/5.4/eloquent-relationships
    //warum hier belongsTo() und hasOne? ist die Abhängigkeit bei allen nicht ganu gleich?
    /**
     * @return Produkt, welches von der Transaktion verwendet wird.
     */
    public function product() {
    	return $this->belongsTo('\bi_testdaten\Produkt', 'produkt_id')->get()->first();
    }

}
