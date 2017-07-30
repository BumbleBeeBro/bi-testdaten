@extends('layouts/layoutFrontpage')

@section('content')
<div class="col-md-12">
    <h2>
        DWH-Operationen
    </h2>
    <p>
        Zwei beispielhafte Datawarehouse Operationen, die mit den genierierten Daten durchgeführt werden könnten. Als Datengrundlage dient das letzte erstellte Ergebnis.
    </p>
</div>
<hr/>
@endsection

@section('form')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @include('layouts/errors')
            @if(isset($total_sales))
                <p>
                    Gesamtumsatz des Produkts: {{$total_sales}} Geldeinheiten
                </p>
            @endif
            @if(isset($products_sold))
            <p>
                Anzahl verkaufte Produkte des Mitarbeiters {{$products_sold}} Stück
            </p>
            @endif
            <hr/>
            </div>
            <div class="col-md-6">
                <form action="/Mitarbeiter/products_sold" method="POST" role="form">
                {{ csrf_field() }}
                    <div class="input-group ">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                Verkaufte Produkte von Mitarbeiter
                            </button>
                        </span>
                        <input class="form-control" name="id" required type="number">
                        </input>
                    </div>
                    <!-- /input-group -->
                </form>
            </div>
            <div class="col-md-6">
                <form action="/Produkte/total_sales" method="POST" role="form">
                {{ csrf_field() }}
                    <div class="input-group ">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                Umsatz für Produkt
                            </button>
                        </span>
                        <input class="form-control" name="id" required type="number">
                        </input>
                    </div>
                    <!-- /input-group -->
                </form>
                <br/>
            </div>
        </div>
    </div>
    @endsection
</div>