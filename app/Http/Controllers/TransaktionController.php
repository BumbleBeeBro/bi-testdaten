<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use?
use \App\Kunde;
use \App\Mitarbeiter;
use \App\Store;
use \App\Produkt;
use \App\Transaktion;
use Illuminate\Support\Facades\Log;


class TransaktionController extends Controller
{
    public function create_api() {

    	$shipping = request('shipping');
    	$discount = request('discount');
    	$paymentMethod = request('paymentMethod');

    	$faker = \Faker\Factory::create();

        //Erstelle neuen Kunden
        $this->curl_get('bi-testdaten.exumble.de/Kunde/create', 'name=true&firstName=true&adress=true&email=true&phoneNumber=true&birthDate=true'); 

        $created_transactions = '';

        for ($i=0; $i < $faker->numberBetween($min = 1, $max = 10); $i++) { 

            if ($shipping) {
                $create_array['shipping'] = $faker->randomElement(['Abholung', 'Lieferung']);
            }

            if ($discount) {
                 $create_array['discount'] = $faker->randomFloat($nbMaxDecimals = 2 , $min = 0, $max = 1);
            }

            if ($paymentMethod) {
                $create_array['paymentMethod'] = $faker->randomElement(['Barzahlung', 'Kreditkartenzahlung', 'Onlinezahlung', 'Rechnungszahlung']);
            }

            //letzer erstellter Kunde
            $create_array['kunde_id'] = Kunde::orderByDesc('id')->first()->id;
        
            $create_array['store_id'] = Store::inRandomOrder()->get()->first()->id;

            $create_array['mitarbeiter_id'] =  Mitarbeiter::inRandomOrder()->get()->first()->id;

            $create_array['produkt_id'] = Produkt::inRandomOrder()->get()->first()->id;

            $create_array['date'] = $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d');

            $transaktion = Transaktion::create($create_array);

            $transaktion->calculate_price();

            $created_transactions = $created_transactions . $transaktion->id . ' ';

        }

        //return ?

	}

    

        //http://domain options ['eins', 'zwei']
    public function curl_get($url, $options) {

        $url = $url . '?' . $options;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);

        echo $result . '<br />';

        curl_close($ch);

    }
}
