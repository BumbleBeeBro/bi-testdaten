<?php

namespace bi_testdaten\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use bi_testdaten\Kunde;
use bi_testdaten\Mitarbeiter;
use bi_testdaten\Store;
use bi_testdaten\Produkt;
use bi_testdaten\Transaktionskopf;
use bi_testdaten\Transaktionsposition;
use bi_testdaten\Hersteller;

/**
 * Hautcontroller. Der SimulationController dirigiert das Erstellen der benätigten Models und gibt den Befehl zur Datenerstellung. Diese Klasse erstellt zudem Fehlerwerte und kann zudem die erstellten Ergebnisse zurückgeben.
 */
class SimulationController extends Controller
{


    /**
     * Leitet den Simulationsprozess, indem die Funktion die Models erstellt und die Zufallsdatengenerierung anstößt. Eingegebene Daten werden validiert. Zudem wird die Erstellung von Fehlerdaten eingeleitet. 
     * @param  Request $request -> Formulardaten, die die Spezifikationen des Benutzers beinhalten.
     */
    public function simulate(Request $request) {
        
        //validate Input
        $this->validate($request, [

            'k_amount' => 'required|integer|min:0',
            'p_amount' => 'required|integer|min:0',
            's_amount' => 'required|integer||min:1',
            'h_amount' => 'required|integer||min:0',
            'm_amount' => 'required|min:'.$this->validateEmployees($request).'|integer',
            //'m_amount' => 'required|min:'.$request->s_amount.'|integer',
            't_min_date' => 'required|max:'.$request->t_max_date.'|date',
            't_max_date' => 'required|date|after:t_min_date',
            'prob_faultyData' => 'nullable|integer|min:0|max:100',
            'max_trans_pro_k' => 'required|integer|min:0',
            'max_pos_pro_trans' => 'required|integer|min:0'

            ]);

        //erstelle Faker-Factory
        $faker = \Faker\Factory::create();

        //logging
        Log::info('truncate all tables...');

        //leere alle Tabellen
        $this->truncate();

        //erstelle Stores
        $store_input = $this->get_input(['s_address', 's_phoneNumber', 's_email', 's_website'], $request);

        for ($i=0; $i < $request->s_amount; $i++) { 

            $store = new Store();

            $result = $store->generate($store_input);

            Log::info($result);

        }



        //erstelle Mitarbeiter
        $employee_input = $this->get_input(['m_name', 'm_firstName','s_employees'], $request);

        if (null != $request->exists('s_employees')) {

            for ($i=0; $i < $request->m_amount; $i++) { 

                $employee = new Mitarbeiter();

                $result = $employee->generate($employee_input, $i + 1);

                Log::info($result);

            }
        }

        //erstelle Hersteller
        $producer_input = $this->get_input(['h_name', 'h_email', 'h_address'], $request);

        $producer_input['language'] = $request->h_language;

        if (null != $request->exists('p_producer')) {

            for ($i=0; $i < $request->h_amount; $i++) {

                $producer = new Hersteller();

                $result = $producer->generate($producer_input);

                Log::info($result);

            }
        }

        //erstelle Produkte
        $product_input = $this->get_input(['p_name', 'p_price', 'p_producer', 'p_description', 'p_tax'], $request);

        for ($i=0; $i < $request->p_amount; $i++) {

            $product = new Produkt();

            $result = $product->generate($product_input);

            Log::info($result);

        }

        //starte Transaktionsgenerierung
        $customer_input = $this->get_input(['k_name', 'k_firstName', 'k_address', 'k_email', 'k_phoneNumber', 'k_birthDate'], $request);

        $transactionHead_input = $this->get_input(['t_shipping', 't_discount', 't_paymentMethod','s_employees'], $request);

        //füge zum input das Start- und Enddatum hinzu.
        $transactionHead_input['t_min_date'] = request('t_min_date');
        $transactionHead_input['t_max_date'] = request('t_max_date');

        $transactionPosition_input = $this->get_input(['t_number' ,'t_discount', 't_net_price'], $request);
        
        //erstelle Kunden
        for ($i=0; $i < $request->k_amount; $i++) {

            Log::info('Starte Erstellung eines Kunden und dazugehörigen Transaktionen');

            $kunde = new Kunde();

            $result = $kunde->generate($customer_input);

            Log::info($result);

            //erstelle zwischen 1 und maximal angegebenen Transaktionsköpfe
            for ($j=0; $j < $faker->numberBetween($min = 1, $max = $request->max_trans_pro_k); $j++) { 

                $transactionHead = new Transaktionskopf();

                $result = $transactionHead->generate($transactionHead_input);

                Log::info($result);

                //erstelle zwischen 1 und maximale angegebenen Anzahl an Positionen pro Transaktion.
                for ($k=0; $k < $faker->numberBetween($min = 1, $max = $request->max_pos_pro_trans); $k++) { 
                    $transactionPostion = new Transaktionsposition();

                    $result = $transactionPostion->generate($transactionPosition_input);

                    $transactionPostion->calculate_price();

                    Log::info($result);
                }

            }

        }

        //sollen Fehlerdaten eingebunden werden?
        if (request('check_faultyData') !== null) {

            //Abfrage der Fehlerwahrscheinlichkeit.
            $prob_faultyData = floatval(request('prob_faultyData'));

            //Abfrage, ob Fehlerwerte nur 'null' sein sollen.
            $only_null = request('only_null');

            //Erstelle Fehlerdaten für jedes Model.
            $this->generateFaultyData($models = Hersteller::all(), $only_null, $prob_faultyData);

            $this->generateFaultyData($models = Kunde::all(), $only_null, $prob_faultyData);

            $this->generateFaultyData($models = Mitarbeiter::all(), $only_null, $prob_faultyData);

            $this->generateFaultyData($models = Produkt::all(), $only_null, $prob_faultyData);

            $this->generateFaultyData($models = Store::all(), $only_null, $prob_faultyData);

        }

        //Ergebnisse als JSON speichern.
        $this->save_results();


       return redirect('/results/show');


    }

    /**
     * Löscht alle Datenbankeinträge.
     */
    public function truncate() {

        Kunde::truncate();
        Store::truncate();
        Hersteller::truncate();
        Mitarbeiter::truncate();
        Produkt::truncate();
        Transaktionskopf::truncate();
        Transaktionsposition::truncate();

        Log::info('... success');

    }

    /**
     * Ermittelt, welche der in einem Array angegebenen Checkboxen existieren und interpretiert dies in boolesche Werte (true = ausgewählt).
     * @param  Array $input_array -> Array mit zu überprüfenden Checkboxen.
     * @param  $checkboxes -> Checkboxen, die überprüft werden sollen.
     * @return Array -> Array mit boolscher Angabe, welche Checkboxen gesetzt sind.
     */
    public function get_input($input_array, $checkboxes) {

        foreach ($input_array as $value) {
            
            /*//https://stackoverflow.com/questions/26550009/laravel-checking-input-isset*/

            //ist die Checkbox ausgewählt?
            if (null != $checkboxes->exists($value)) {
                $input_array[$value] = true;
            }
            else {
                $input_array[$value] = false;
            }
        }

        return $input_array;

    }

    /**
     * Speichert alle erstellten Daten im JSON-Format.
     * @return Weiterleitung zur letzten Seite inklusive Fehlermeldung, falls ein Fehler auftritt.
     */
    public function save_results() {

        //Lese alle erstellten Daten ein.
        $result = [
        'Kunden' => Kunde::all()->toArray(),
        'Mitarbeiter' => Mitarbeiter::all()->toArray(), 
        'Stores' => Store::all()->toArray(), 
        'Produkte' =>Produkt::all()->toArray(), 
        'Hersteller' =>Hersteller::all()->toArray(), 
        'Transaktionsköpfe' => Transaktionskopf::all()->toArray(),
        'Transaktionspositionen' => Transaktionsposition::all()->toArray()
        ];

        //fopen kann errors erzeugen bei unzureichenden Berechtigungen oder überschreiben*/

        //öffne JSON.
        try{
            $result_json = fopen('results/result_' . \Carbon\Carbon::now('Europe/Berlin')->format('Y-m-d_h-i-s') . '.json', 'w');
        }
        //Fehlerbehandlung.
        catch(\Exception $e){
            Log::error($e);

            return back()->withErrors([

                'message' => 'Error in writing the result, see logfile'

                ]);
        }

        //schreibe JSON.
        fwrite($result_json, json_encode($result));
    }

    /**
     * Funktion, um Daten eines Models zu verfälschen. Je nach eingegebener Wahrscheinlichkeit wird bei jedem Datum überprüft, ob es in einen Fehlerwert umgewandelt werden soll. Die gewählten Daten werden mit Fehlerwerten überschrieben. Fehlerwerte sind entweder "null" oder "ERROR" für Strings, "0" für Integers, oder "01-01-1970" für Dates.
     * @param  Model $models -> Modelinstanzen, wessen Daten verfälscht werden sollen.
     * @param  Boolean $only_null -> Gibt an, ob alle Fehlerdaten den Wert "null" haben sollen.
     * @param  Integer $prob_faultyData -> Wahrscheinlichkeit, mit der ein Wert fehlerhaft sein soll. (Integer zwischen 0 und 100).
     */
    public function generateFaultyData(\Illuminate\Database\Eloquent\Collection $models, $only_null, $prob_faultyData) {

        /*// use the factory to create a Faker\Generator instance*/

        //erstelle Faker-Factory.
        $faker = \Faker\Factory::create();

        

        /*//$attributes = $this->getAttributes();*/

        //für jedes Model.
        foreach ($models as $model) {
            
            /*//https://stackoverflow.com/questions/33512184/get-laravel-models-with-all-attributes*/

            //Spalten einlesen.
            $columns = $model->getFillable();
        
            foreach ($columns as $column) {

                //bestimme wie häufig Daten geändert werden sollen.
                if ($faker->boolean($chanceOfGettingTrue = $prob_faultyData)) {

                    //neue abfrage
                    if($model->$column != null)  {  

                        if($only_null) {
                            $model->$column = null;

                            $model->save();

                            Log::info('Attribut ' . $column . ' null gesetzt');

                        }
                        else {
                            
                            /*//$type = gettype($model->$column);
                            //https://stackoverflow.com/questions/18562684/how-to-get-database-field-type-in-laravel
                            //https://laracasts.com/discuss/channels/laravel/pdomysql-driver-not-found*/
                            $type = \DB::connection()->getDoctrineColumn($model->getTable(), $column)->getType()->getName();

                            //In 30% der Fälle sollen Fehler 'null' sein.
                             if ($faker->boolean($chanceOfGettingTrue = 30)) {

                                 $model->$column = null;

                                 $model->save();

                                Log::info('Attribut ' . $column . ' auf null gesetzt');

                            // Fehlerdatum = 'ERROR', falls der Datentyp String ist.
                             } elseif($type == 'string') {
                                $model->$column = 'ERROR';

                                $model->save();

                                Log::info('Attribut ' . $column . ' auf "ERROR" gesetzt');

                            // Fehlerdatum = '0', falls der Datentyp Integer ist.
                            } elseif($type == 'integer') {
                                $model->$column = -1;

                                $model->save();

                                Log::info('Attribut ' . $column . ' auf -1 gesetzt');

                            // Fehlerdatum = '1970-01-01', falls der Datentyp Date ist.
                            } elseif($type == 'date') {
                                $model->$column = date('Y-m-d H:i:s', strtotime('01.01.1970'));;

                                $model->save();

                                Log::info('Attribut ' . $column . ' auf 01/01/1970 gesetzt');

                            }
                        }
                    }
                }
            }
        }
    }

    public function validateEmployees(Request $request) {

        if (null != $request->exists('s_employees')) {

            return $request->s_amount;
        }
        else{
            return 0;
        }

    }
}
