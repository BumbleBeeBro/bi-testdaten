@
@extends('layouts/layoutFrontpage')

@section('content')
<h2>
    Please Fix
</h2>
<hr />
@endsection

@section('form')
  @if(isset($total_sales))
    <div class="col-md-12">
      <p> Gesamtumsatz des Produkts: {{$total_sales}}</p>
    </div>
  @endif
  @if(isset($products_sold))
    <div class="col-md-12">
      <p> Anzahl verkaufte Produkte des Mitarbeiters {{$products_sold}}</p>
    </div>
  @endif
<hr />
<form role="form" method="GET" action="/Mitarbeiter/1/products_sold">
  <button class="btn btn-default" type="submit">
    Verkaufte Produkte Mitarbeiter 1
  </button>
</form>

<form role="form" method="GET" action="/Produkte/1/total_sales">
  <button class="btn btn-default" type="submit">
    Umsatz von Produkt 1
  </button>
</form>
@endsection
