<?php

namespace App\Http\Controllers;

use App\Kunde;
use App\Mitarbeiter;
use App\Store;
use App\Produkt;
use \App\Transaktion;

class TestController extends Controller
{
	//depracted !!!
    public function test() {

        $this->truncate();

    	for ($i=0; $i < 50; $i++) {

    	$this->curl_get('bi-testdaten.exumble.de/Store/create', 'adress=true&phoneNumber=true&email=true&website=true');

    	$this->curl_get('bi-testdaten.exumble.de/Mitarbeiter/create', 'name=true&firstName=true');

    	$this->curl_get('bi-testdaten.exumble.de/Produkt/create', 'name=true&price=true&producer=true&description=true&tax=true');

    	}

        for ($j=0; $j < 50; $j++) { 
            $result = $this->curl_get('bi-testdaten.exumble.de/Transaktion/create', 'shipping=true&discount=true&paymentMethod=true');

        }

        //https://laravel.com/docs/5.4/eloquent-serialization
        $result = [Kunde::all()->toArray(), Mitarbeiter::all()->toArray(), Store::all()->toArray(), Produkt::all()->toArray(), Transaktion::all()->toArray()];

        //https://www.w3schools.com/php/php_file_create.asp
        $result_json = fopen('results/result' . \Carbon\Carbon::now()->format('Y-m-d_h-i-s') . '.json', 'w');

        fwrite($result_json, json_encode($result));
        

        //return redirect('/results/show');

    }


    //http://domain options ['eins', 'zwei']
    //http://php.net/manual/de/book.curl.php
	public function curl_get($url, $options) {

		$url = $url . '?' . $options;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);

        echo $result  . '<br />';

		curl_close($ch);

	}



}
