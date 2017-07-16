@extends('layouts/layoutFrontpage')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>
                Generierungstool für BI-Testdaten
            </h2>
            <hr />
            <div class="form-group">
                <p> 
                    Mit diesem Tool können zufällige BI-Testdaten generiert werden. 
                </p>
                <p> 
                    Außerdem kann hier ein Beispieltext stehen. 
                </p>
            </div>
            <div class="form-group">
                <p> 
                    Einige Attribute (kursiv) können auch mit eigenen Werten befüllt werden. Dazu muss zunächst das Feld <strong>"Benutzerspezifische Werte verwenden."</strong> ausgwählt werden. Durch Entfernen des Hakens bei bestimmten Attributen können anschließend benutzerspezifische Werte eingetragen und verwendet werden. 
                </p>
            </div>
            <div class="checkbox">
                <label>
                    <input name="custom_check" id="c_check" type="checkbox"/>
                        <b>Benutzerspezifische Werte verwenden.</b>
                </label>
            </div>
            <div class="alert alert-warning">
                <p> 
                    <strong>Maximale Ausführungszeit 5 Min.</strong> Änderbar in /etc/php5/apache2/php.ini (max_execution_time)
                </p>
                <p> 
                    Die Felder <strong>"Startdatum"</strong> und <strong>"Enddatum"</strong> sind nicht mit Mozilla Firefox kompatibel. Stattdessen müssen die Daten manuell im Format <strong>"jjjj-mm-tt"</strong> eingegegeben werden.
                </p>
            </div>
            <hr/>
        </div>
    </div>
</div>
@endsection

@section('form')


<script>
    function show(id) { 
    if(document.getElementById) { 
        var mydiv = document.getElementById(id);
        var c_check = document.getElementById('c_check');
        if(c_check.checked){ 
            mydiv.style.display = (mydiv.style.display=='block'?'none':'block'); 
        }    
    } 
}
</script>

<form action="/simulate" method="POST" role="form">
    {{ csrf_field() }}
    <div class="container-fluid">
        <div class="row">
            @include('layouts/errors')
        </div>
        <div class="row">
            {{-- Stammdaten --}}
            <!--Kunde-->
            <div class="col-sm-6 col-md-4">
                <h3>
                    Kunde
                </h3>
                <div class="form-group">
                    <label for="Anzahl">
                        Anzahl an zu erstellenden Kunden.
                    </label>
                    <input class="form-control" id="Anzahl" name="k_amount" value=10 required type="number"/>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="k_name" type="checkbox"/>
                        Name
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="k_firstName" type="checkbox"/>
                        Vorname
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="k_adress" type="checkbox"/>
                        Adresse
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="k_email" type="checkbox"/>
                        E-Mail
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="k_phoneNumber" type="checkbox"/>
                        Telefon
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="k_birthDate" type="checkbox"/>
                        Geburtsdatum
                    </label>
                </div>



                <hr/>



                <h3>
                    Store
                </h3>
                <div class="form-group">
                    <label for="Anzahl">
                        Anzahl an zu erstellenden Stores.
                    </label>
                    <input class="form-control" id="Anzahl" name="s_amount" value=10 required type="number"/>
                </div>
                <div class="checkbox">
                    <label>
                        <!-- address ist falsch geschrieben -->
                        <input checked="" name="s_adress" type="checkbox"/>
                        Adresse
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="s_phoneNumber" type="checkbox"/>
                        Telefonnummer
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="s_email" type="checkbox"/>
                        E-Mail
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="s_website" type="checkbox"/>
                        Website
                    </label>
                </div>



                <hr/>



            </div>
            <!--Mitarbeiter-->
            <div class="col-sm-6 col-md-4">
                <h3>
                    Mitarbeiter
                </h3>
                <div class="form-group">
                    <label for="Anzahl">
                        Anzahl an zu erstellenden Mitarbeiter.
                    </label>
                    <input class="form-control" id="Anzahl" name="m_amount" value=10 required type="number"/>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="m_name" type="checkbox"/>
                        Name
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="m_firstName" type="checkbox"/>
                        Vorname
                    </label>
                </div>



                <hr/>



                <h3>
                    Produkte
                </h3>
                <div class="form-group">
                    <label for="Anzahl">
                        Anzahl an zu erstellenden Produkten.
                    </label>
                    <input class="form-control" id="Anzahl" name="p_amount" value=10 required type="number"/>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_name" onchange="javascript:show('produktnamen'); return false" type="checkbox"/>
                        <i>Name</i>
                    </label>
                </div>
                <div class="form-group" id="produktnamen" style="display: none">
                    <label for="Anzahl">
                        Custom-Produktnamen:
                    </label>
                    <textarea class="form-control" cols="20" name="p_name_custom" rows="4">
                    </textarea>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_price" onchange="javascript:show('preis'); return false" type="checkbox"/>
                        <i>Preis</i>
                    </label>
                </div>
                <div id="preis" style="display: none">
                  <div class="form-group col-xs-6">
                      <label for="min_price">
                          Min. Preis:
                      </label>
                      <input class="form-control" id="min_price" name="p_price_custom_min" type="number"/>
                  </div>
                  <div class="form-group col-xs-6">
                      <label for="max_price">
                          Max. Preis:
                      </label>
                      <input class="form-control" id="max_price" name="p_price_custom_max" type="number"/>
                  </div>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_producer" type="checkbox"/>
                        Hersteller
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_description" onchange="javascript:show('beschreibung'); return false" type="checkbox"/>
                        <i>Beschreibung</i>
                    </label>
                </div>
                <div class="form-group" id="beschreibung" style="display: none">
                    <label for="Anzahl">
                        Custom-Beschreibungen:
                    </label>
                    <textarea class="form-control" cols="20" name="p_name_custom" rows="4">
                    </textarea>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_tax" onchange="javascript:show('steuer'); return false" type="checkbox"/>
                        <i>Steuersatz</i>
                    </label>
                </div>
                <div class="form-group" id="steuer" style="display: none">
                    <label for="Anzahl">
                        Custom-Steuersätze:
                    </label>
                    <textarea class="form-control" cols="20" name="p_name_custom" rows="4">
                    </textarea>
                </div>



                <hr/>
            </div>



            <div class="col-sm-6 col-md-4">
                <h3>
                    Hersteller
                </h3>
                <div class="form-group">
                    <label for="Anzahl">
                        Anzahl an zu erstellenden Herstellern.
                    </label>
                    <input class="form-control" id="Anzahl" name="h_amount" value=10 required type="number"/>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="h_name" type="checkbox"/>
                        Name
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="h_email" type="checkbox"/>
                        E-Mail
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="h_adress" type="checkbox"/>
                        Adresse
                    </label>
                </div>
                {{-- Transaktionsdaten --}}
                


                <hr/>



                <h3>
                    Transaktionsdaten
                </h3>
                <div class="checkbox">
                    <label>
                        <input checked="" name="t_paymentMethod" type="checkbox"/>
                        Zahlungsmethode
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="t_shipping" type="checkbox"/>
                        Versand
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="t_discount" type="checkbox"/>
                        Rabatt
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="t_number" type="checkbox"/>
                        <b>Mehrere Produkte pro Position</b>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="t_net_price" type="checkbox"/>
                        <b>Nettopreis pro Position berechnen</b>
                    </label>
                </div>
                <div class="form-group col-xs-6">
                    <label for="Anzahl">
                        Startdatum:
                    </label>
                    <input class="form-control" name="t_min_date" value="2007-01-01" required type="date"/>
                </div>
                <div class="form-group col-xs-6">
                    <label for="Anzahl">
                        Enddatum:
                    </label>
                    <input class="form-control" name="t_max_date" value=2017-01-01 required type="date"/>
                </div>
                <hr/>
            </div>
        </div>



        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit">
                        Simulieren
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</form>
@endsection
