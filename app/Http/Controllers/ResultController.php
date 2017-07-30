<?php

namespace bi_testdaten\Http\Controllers;

use Illuminate\Http\Request;
use bi_testdaten\Mitarbeiter;
use bi_testdaten\Produkt;


class ResultController extends Controller
{

    /**
     * Funktion zum Anzeigen der Ergebnisse.
     * @return View, welche die Ergebnisse wiedergibt.
     */
    public function results() {

    	$results = glob('results/*');

    	return view('results', compact('results'));
    }

    /**
     * Löscht alle Ergebnisse. Und gibt anschließend die leere Ergebnisseite aus.
     * @return Redirection, die die Route '/results/show' auslöst.
     */
    public function delete() {
    	
        /*//http://php.net/manual/de/function.glob.php
    	//https://stackoverflow.com/questions/4594180/deleting-all-files-from-a-folder-using-php*/

    	$results = glob('results/*');

        //lösche jedes existierende Ergebnis.
    	foreach($results as $result){
  			if(is_file($result)) {
  				unlink($result);
  			}	 
		}
    	
    	return redirect('/results/show');
    }
}
