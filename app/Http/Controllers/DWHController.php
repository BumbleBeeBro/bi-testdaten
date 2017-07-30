<?php

namespace bi_testdaten\Http\Controllers;

use Illuminate\Http\Request;
use bi_testdaten\Mitarbeiter;
use bi_testdaten\Produkt;


class DWHController extends Controller
{
    /**
     * Funktion, die die DWH-Operations-View zurückgibt.
     * @return View, Gibt die View 'dwh-operations' zurück.
     */

    public function home() {

        return view('dwh-operations', compact('total_sales', 'products_sold'));
    }

	/**
	 * Gibt die Anzahl der beteiligten Transaktionen wieder.
	 * @return Integer, Anzahl der verkauften Produkte.
	 */
    public function products_sold() { 

    	$employee = Mitarbeiter::where('id', request('id'))->get()->first();

    	if ($employee == null) {
			return redirect('/dwh-operations')->withErrors('Mitarbeiter existiert nicht!');
		}

    	$products_sold = null;

    	foreach ($employee->transactions() as $transactionhead) {
    		foreach ($transactionhead->transactionbodies() as $body) {
    			$products_sold += $body->amount;
    		}
    	}

		 return view('dwh-operations', compact('products_sold'));
    }



    /**
	 * Ermittle die Verkaufe eines bestimmten Produktes.
	 * @param  Produkt, von welchem die Verkaeufe ermittelt werden sollen.
	 * @return View, mit uebergebenen Verkaeufen.
	 */
	public function total_sales() {

    	$product = Produkt::where('id', request('id'))->get()->first();

    	if ($product == null) {
			return redirect('/dwh-operations')->withErrors('Produkt existiert nicht!');
		}

		$total_sales = null;

		foreach ($product->transactions() as $body) {

			$total_sales += $body->amount * $body->net_price;
		}

		 return view('dwh-operations', compact('total_sales'));
	}
}
