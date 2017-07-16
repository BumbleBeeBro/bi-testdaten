<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Kunde;
use App\Mitarbeiter;
use App\Store;
use App\Produkt;
use App\Transaktionskopf;
use App\Transaktionsposition;
use App\Hersteller;

class SimulationController extends Controller
{


    /**
     * @param  Request, die Formulardaten
     * @return [type]
     */
    public function simulate(Request $request) {
        
        //validate Input
        $this->validate($request, [

            'k_amount' => 'required|integer',
            'p_amount' => 'required|integer',
            's_amount' => 'required|integer',
            'm_amount' => 'required|min:'.$request->s_amount.'|integer',
            't_min_date' => 'required|max:'.$request->t_max_date.'|date',
            't_max_date' => 'required|date|after:t_min_date'

            ]);

        $faker = \Faker\Factory::create();

        //https://laravel.com/docs/5.4/errors#logging
        Log::info('truncate all tables...');

        //leere alle Tabellen
        $this->truncate();

        //erstelle Stores
        $store_input = $this->get_input(['s_adress', 's_phoneNumber', 's_email', 's_website'], $request);

        for ($i=0; $i < $request->s_amount; $i++) { 

            $store = Store::create();

            $result = $store->generate($store_input);

            Log::info($result);

        }



        //erstelle Mitarbeiter
        $employee_input = $this->get_input(['m_name', 'm_firstName'], $request);

        for ($i=0; $i < $request->m_amount; $i++) { 

            $employee = Mitarbeiter::create();

            $result = $employee->generate($employee_input);

            Log::info($result);

        }

        //erstelle Herteller
        $producer_input = $this->get_input(['h_name', 'h_email', 'h_adress'], $request);

        for ($i=0; $i < $request->h_amount; $i++) {

            $producer = Hersteller::create();

            $result = $producer->generate($producer_input);

            Log::info($result);

        }

        //erstelle Produkte
        $product_input = $this->get_input(['p_name', 'p_price', 'p_producer', 'p_description', 'p_tax'], $request);

        for ($i=0; $i < $request->p_amount; $i++) {

            $product = Produkt::create();

            $result = $product->generate($product_input);

            Log::info($result);

        }

        //starte Transaktionsgenerierung
        $customer_input = $this->get_input(['k_name', 'k_firstName', 'k_adress', 'k_email', 'k_phoneNumber', 'k_birthDate'], $request);

        $transactionHead_input = $this->get_input(['t_shipping', 't_discount', 't_paymentMethod'], $request);

        //veränder dates in unix codierung um diese benutzen zu können.
        $transactionHead_input['t_min_date'] = request('t_min_date');
        $transactionHead_input['t_max_date'] = request('t_max_date');
        // $transactionHead_input['t_min_date'] = strtotime(request('t_min_date'));

        // $transactionHead_input['t_max_date'] = strtotime(request('t_max_date'));

        $transactionPosition_input = $this->get_input(['t_number' ,'t_discount', 't_net_price'], $request);
        

        for ($i=0; $i < $request->k_amount; $i++) {

            //Hier Eher: 'Starte Erstellung einer Transaktion und dazugehörigen Kunden' oder nicht?
            Log::info('Starte Erstellung eines Kunden und dazugehörigen Kunden');

            $kunde = Kunde::create();

            $result = $kunde->generate($customer_input);

            Log::info($result);

            for ($j=0; $j < $faker->numberBetween($min = 1, $max = 10); $j++) { 

                $transactionHead = Transaktionskopf::create();

                $result = $transactionHead->generate($transactionHead_input);

                Log::info($result);

                for ($k=0; $k < $faker->numberBetween($min = 1, $max = 10); $k++) { 
                    $transactionPostion = Transaktionsposition::create();

                    $result = $transactionPostion->generate($transactionPosition_input);

                    $transactionPostion->calculate_price();

                    Log::info($result);
                }

            }

        }

        $this->save_results();

        return redirect('/results/show');


    }


    public function calculateTimeDiff($year) {

        /*if ($year == date("Y")) {
        
            return 'now';
    
        }*/
        if ($year <= date("Y")) {
        
            $res = $year - date("Y");
             return $res.' years';
    
         }
         if ($year > date("Y")) {
        
            $res = $year - date("Y");
            return '+'.$res.' years';
    
        }
    }

    public function results() {

    	$results = glob('results/*');

    	return view('results', compact('results'));
    }

    public function dwh_operations() {

        return view('dwh-operations');
    }

    public function delete() {
    	//http://php.net/manual/de/function.glob.php
    	//https://stackoverflow.com/questions/4594180/deleting-all-files-from-a-folder-using-php
    	$results = glob('results/*');

    	foreach($results as $result){
  			if(is_file($result)) {
  				unlink($result);
  			}	 
		}
    	
    	return redirect('/results/show');
    }

    public function truncate() {

        Kunde::truncate();
        Store::truncate();
        Hersteller::truncate();
        Mitarbeiter::truncate();
        Produkt::truncate();
        Transaktionskopf::truncate();
        Transaktionsposition::truncate();

        Log::info('... success <br />');

    }


    public function get_input($input_array, $checkboxes) {

        foreach ($input_array as $value) {
            //https://stackoverflow.com/questions/26550009/laravel-checking-input-isset
            if (null != $checkboxes->exists($value)) {
                $input_array[$value] = true;
            }
            else {
                $input_array[$value] = false;
            }
        }

        return $input_array;

    }

    public function save_results() {
        //https://laravel.com/docs/5.4/eloquent-serialization
        $result = [
        'Kunden' => Kunde::all()->toArray(),
        'Mitarbeiter' => Mitarbeiter::all()->toArray(), 
        'Stores' => Store::all()->toArray(), 
        'Produkte' =>Produkt::all()->toArray(), 
        'Hersteller' =>Hersteller::all()->toArray(), 
        'Transaktionsköpfe' => Transaktionskopf::all()->toArray(),
        'Transaktionspositionen' => Transaktionsposition::all()->toArray()
        ];

        //http://carbon.nesbot.com/docs/
        //https://www.w3schools.com/php/php_file_create.asp
        //fopen kann errors erzeugen bei unzureichenden Berechtigungen oder überschreiben
        try{
            $result_json = fopen('results/result' . \Carbon\Carbon::now()->format('Y-m-d_h-i-s') . '.json', 'w');
        } 
        catch(\Exception $e){
            Log::error($e);

            return back()->withErrors([

                'message' => 'Error in writing the result, see logfile'

                ]);
        }
        $result_json = fopen('results/result' . \Carbon\Carbon::now()->format('Y-m-d_h-i-s') . '.json', 'w');

        fwrite($result_json, json_encode($result));
    }

}
