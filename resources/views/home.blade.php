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
                    Mit diesem Tool können <strong>zufällige BI-Testdaten</strong> generiert werden. Die erstellten Daten eignen sich beispielsweise zum Testen eines <strong>einer Data-Warehouse Architektur für den Einzelhandel</strong> oder zur <strong>Schulung von Mitarbeitern</strong>. Je nach Wunsch können dabei Daten für die Dimensionen Kunde, Store, Mitarbeiter, Produkte und Hersteller mit entsprechenden Attributen erstellt werden. Die Testdaten können anschließend im <strong>JSON-Format</strong> heruntergeladen werden.
                     
                </p>
            </div>
            <div class="form-group">
                <p> 
                    Bitte wählen Sie zunächst die <strong>gewünschten Attribute</strong> mithilfe der Checkboxen aus. Anschließend muss die jeweilige <strong>Anzahl</strong> von <strong>Kunden, Stores, Mitarbeitern, Produkten und Herstellern</strong> festgelegt werden. Die <strong>Hersteller</strong> werden allerdings nur erstellt, wenn unter der Kategorie <strong>Produkte</strong> dieses als Attribut ausgewählt worden ist. In der Kategorie <strong>Transaktionsdaten</strong> kann zusätzlich festgelegt werden, ob mehrere Produkte pro Position verwendet werden sollen. Der <strong>Nettopreis</strong> pro Position kann nur berechnet werden, wenn der Preis und der Steuersatz des Produktes, sowie der Rabatt bei der Transaktion ausgewählt ist. Die <strong>Anzahl der Transaktionen</strong> wird durch die <strong>Kundenanzahl</strong> geregelt.
                </p>
                <p>
                    Abschließend kann festgelegt werden, ob die zu erstellenden Daten <strong>fehlerhafte Daten</strong> beinhalten sollen. Neben dem Anteil der fehlerhaften Daten kann zudem festgelegt werden, ob diese nur als <strong>NULL-Werte</strong> erstellt werden sollen oder ob zudem <strong>datentypspezifische Fehlerdaten</strong> erstellt werden sollen.
                </p>

            </div>
  <!--          <div class="checkbox">
                <label>
                    <input name="check_faultyData" type="checkbox"/>
                        <b>Fehlerhafte Daten integrieren. Angabe in Prozent (%). </b>
                </label>
                <div class="form-group">
                    <input class="form-control" name="prob_faultyData" type="number"/>
                </div>
            </div>-->
            <div class="alert alert-warning">
                <p> 
                    <strong>Maximale Ausführungszeit 5 Min.</strong> Änderbar in /etc/php5/apache2/php.ini (max_execution_time)
                </p>
            </div>
            <hr/>
        </div>
    </div>
</div>
@endsection

@section('form')

<!--
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
</script> -->

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
                        <input checked="" name="k_address" type="checkbox"/>
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
                        <input checked="" name="s_employees" type="checkbox"/>
                        <b>Mitarbeiter erstellen</b>
                    </label>
                </div>                
                <div class="checkbox">
                    <label>
                        <input checked="" name="s_address" type="checkbox"/>
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
                        <input checked="" name="p_name" type="checkbox"/>
                        Name
                    </label>
                </div>
                <!--onchange="javascript:show('produktnamen'); return false"-->
<!--                <div class="form-group" id="produktnamen" style="display: none">
                    <label for="Anzahl">
                        Custom-Produktnamen:
                    </label>
                    <textarea class="form-control" cols="20" name="p_name_custom" rows="4">
                    </textarea>
                </div>-->
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_price"  type="checkbox"/>
                        Preis
                    </label>
                </div>

<!--                onchange="javascript:show('preis'); return false"
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
                </div> -->
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_producer" type="checkbox"/>
                        <b>Hersteller</b>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_description"  type="checkbox"/>
                        Beschreibung
                    </label>
                </div>
 <!--               onchange="javascript:show('beschreibung'); return false"
                <div class="form-group" id="beschreibung" style="display: none">
                    <label for="Anzahl">
                        Custom-Beschreibungen:
                    </label>
                    <textarea class="form-control" cols="20" name="p_name_custom" rows="4">
                    </textarea>
                </div> -->
                <div class="checkbox">
                    <label>
                        <input checked="" name="p_tax"  type="checkbox"/>
                        Steuersatz
                    </label>
                </div>

<!--                onchange="javascript:show('steuer'); return false"
                <div class="form-group" id="steuer" style="display: none">
                    <label for="Anzahl">
                        Custom-Steuersätze:
                    </label>
                    <textarea class="form-control" cols="20" name="p_name_custom" rows="4">
                    </textarea>
                </div>-->



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
                <div class="form-group">
                    <label for="Sprache">
                        Herkunft der zu erstellenden Hersteller
                    </label>
                    <select class="form-control" list="Sprachen" name="h_language"> 
                        @foreach($languages as $language)
                                @if($language == 'en_US')
                                    <option selected="selected"> {{$language}} </option>
                                @else
                                    <option> {{$language}} </option>
                                @endif
                        @endforeach   
                    </select>
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
                        <input checked="" name="h_address" type="checkbox"/>
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
                    <label for="max_trans_pro_k">
                        Max. Transaktionen pro Kunde:
                    </label>
                    <input id="max_trans_pro_k" class="form-control" name="max_trans_pro_k" value="10" required type="number"/>
                </div>
                <div class="form-group col-xs-6">
                    <label for="max_pos_pro_trans">
                        Max. Positionen pro Transaktion:
                    </label>
                    <input id="max_pos_pro_trans" class="form-control" name="max_pos_pro_trans" value="10" required type="number"/>
                </div>
                <div class="form-group col-xs-6">
                    <label for="t_min_date">
                        Startdatum:
                    </label>
                    <input class="form-control" id="t_min_date" name="t_min_date" value="2007-01-01" required type="date"/>
                </div>
                <div class="form-group col-xs-6">
                    <label for="t_max_date">
                        Enddatum:
                    </label>
                    <input id="t_max_date" class="form-control" name="t_max_date" value=2017-01-01 required type="date"/>
                </div>
                <hr/>
            </div>
        </div>

            <div class="checkbox">
                <label>
                    <input name="check_faultyData" type="checkbox"/>
                        <b>Fehlerhafte Daten integrieren. </b>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input name="only_null" type="checkbox"/>
                        <b>nur NULL Werte als Fehler</b>
                </label>
            </div>
            <div class="form-group">
                    <label for="Anzahl">
                        Wahrscheinlichkeit für fehlerhafte Daten. Angabe in Prozent (%).
                    </label>
                    <input class="form-control" id="Anzahl" name="prob_faultyData" value=10 type="number" step="0.01"/>
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
