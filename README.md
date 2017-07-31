# bi-testdaten

Modelle in app definiert,
	Hersteller,
	Kunde,
	Mitarbeiter, 
	Produkt,
	Store,
	Transaktionskopf
	Transakionsposition

Controller in app/Http/Controllers
	DWHController
	HomeController
	ResultController
	SimulationController

Views in resources/views
	Layout in resources/views/layouts
		errors
		footer
		layoutFrontpage
		nav

	dwh-operations
	home
	imprint
	privacy
	results

Routes in routes/web

Zugriff von außen nur auf den public Ordner
	index
	css
	js
	results (JSON-Dateien)

Logdatei in storage/logs
	laravel

Vorraussetzungen für das Tool:

composer global require "laravel/installer"

composer require "doctrine/dbal"

PHP 5.6 or higher

Apache 2

MySQL

Linux based OS