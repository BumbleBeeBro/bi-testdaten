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
            't_max_date' => 'required|date|after:t_min_date',
            'prob_faultyData' => 'nullable|integer|min:0|max:100'

            ]);

        $faker = \Faker\Factory::create();

        echo '
        <form action="/results/show" method="GET" role="form">
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit">
                        Zu den Ergebnissen
                    </button>
                </div>
            </div>
        </form>';

        //https://laravel.com/docs/5.4/errors#logging
        echo 'truncate all tables... <br />';

        //leere alle Tabellen
        $this->truncate();

        //erstelle Stores
        $store_input = $this->get_input(['s_address', 's_phoneNumber', 's_email', 's_website'], $request);

        for ($i=0; $i < $request->s_amount; $i++) { 

            $store = Store::create();

            $result = $store->generate($store_input);

            echo $result . '<br />';

        }



        //erstelle Mitarbeiter
        $employee_input = $this->get_input(['m_name', 'm_firstName'], $request);

        for ($i=0; $i < $request->m_amount; $i++) { 

            $employee = Mitarbeiter::create();

            $result = $employee->generate($employee_input);

            echo $result . '<br />';

        }

        //erstelle Herteller
        $producer_input = $this->get_input(['h_name', 'h_email', 'h_address'], $request);

        for ($i=0; $i < $request->h_amount; $i++) {

            $producer = Hersteller::create();

            $result = $producer->generate($producer_input);

            echo $result . '<br />';

        }

        //erstelle Produkte
        $product_input = $this->get_input(['p_name', 'p_price', 'p_producer', 'p_description', 'p_tax'], $request);

        for ($i=0; $i < $request->p_amount; $i++) {

            $product = Produkt::create();

            $result = $product->generate($product_input);

            echo $result . '<br />';

        }

        //starte Transaktionsgenerierung
        $customer_input = $this->get_input(['k_name', 'k_firstName', 'k_address', 'k_email', 'k_phoneNumber', 'k_birthDate'], $request);

        $transactionHead_input = $this->get_input(['t_shipping', 't_discount', 't_paymentMethod'], $request);

        //veränder dates in unix codierung um diese benutzen zu können.
        $transactionHead_input['t_min_date'] = request('t_min_date');
        $transactionHead_input['t_max_date'] = request('t_max_date');
        // $transactionHead_input['t_min_date'] = strtotime(request('t_min_date'));

        // $transactionHead_input['t_max_date'] = strtotime(request('t_max_date'));

        $transactionPosition_input = $this->get_input(['t_number' ,'t_discount', 't_net_price'], $request);
        

        for ($i=0; $i < $request->k_amount; $i++) {

            //Hier Eher: 'Starte Erstellung einer Transaktion und dazugehörigen Kunden' oder nicht?
            echo '<br /> Starte Erstellung eines Kunden und dazugehörigen Kunden <br />';

            $kunde = Kunde::create();

            $result = $kunde->generate($customer_input);

            echo $result . '<br />';

            for ($j=0; $j < $faker->numberBetween($min = 1, $max = 10); $j++) { 

                $transactionHead = Transaktionskopf::create();

                $result = $transactionHead->generate($transactionHead_input);

                echo $result . '<br />';

                for ($k=0; $k < $faker->numberBetween($min = 1, $max = 10); $k++) { 
                    $transactionPostion = Transaktionsposition::create();

                    $result = $transactionPostion->generate($transactionPosition_input);

                    $transactionPostion->calculate_price();

                    echo $result . '<br />';
                }

            }

        }

        if (request('check_faultyData') !== null) {

            $prob_faultyData = floatval(request('prob_faultyData'));

            $only_null = request('only_null');

            $this->generateFaultyData($models = Hersteller::all(), $only_null, $prob_faultyData);

            $this->generateFaultyData($models = Kunde::all(), $only_null, $prob_faultyData);

            $this->generateFaultyData($models = Mitarbeiter::all(), $only_null, $prob_faultyData);

            $this->generateFaultyData($models = Produkt::all(), $only_null, $prob_faultyData);

            $this->generateFaultyData($models = Store::all(), $only_null, $prob_faultyData);

        }

        $this->save_results();


        //return redirect('/results/show');


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

        echo '... success <br />';

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

    public function generateFaultyData(\Illuminate\Database\Eloquent\Collection $models, $only_null, $prob_faultyData) {

        // use the factory to create a Faker\Generator instance
        $faker = \Faker\Factory::create();

        

        //$attributes = $this->getAttributes();
        foreach ($models as $model) {
            //https://stackoverflow.com/questions/33512184/get-laravel-models-with-all-attributes
            $columns = $model->getFillable();
        
            foreach ($columns as $column) {

                //bestimme wie häufig daten geändert werden sollen.
                if ($faker->boolean($chanceOfGettingTrue = $prob_faultyData)) {

                    if($only_null) {
                        $model->$column = null;

                        $model->save();

                        echo 'Attribut ' . $column . ' null gesetzt <br />';

                    }
                    else {
                        //$type = gettype($model->$column);
                        //https://stackoverflow.com/questions/18562684/how-to-get-database-field-type-in-laravel
                        //https://laracasts.com/discuss/channels/laravel/pdomysql-driver-not-found
                        $type = \DB::connection()->getDoctrineColumn($model->getTable(), $column)->getType()->getName();

                        echo $type;

                         if($type == 'string') {
                            $model->$column = 'ERROR';

                            $model->save();

                            echo 'Attribut ' . $column . ' ERROR gesetzt <br />';

                        } elseif($type == 'integer') {
                            $model->$column = 0;

                            $model->save();

                            echo 'Attribut ' . $column . ' 0 gesetzt <br />';

                        } elseif($type == 'date') {
                            $model->$column = date('Y-m-d H:i:s', strtotime('01.01.1970'));;

                            $model->save();

                            echo 'Attribut ' . $column . ' auf 01/01/1970 gesetzt <br />';

                        }
                    }
                }
            }
        }
    }
}
