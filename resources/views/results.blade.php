@extends('layouts/layoutFrontpage')

@section('content')
<h2>
    Ergebnisse
</h2>
<hr/>
@endsection

@section('form')
<div class="container-fluid">
    <div class="row">
        @foreach($results as $result)
        <form action="/{{$result}}" class="form-horizontal col-md-6" method="GET">
            <input class="btn btn-info col-xs-3" id="{{$result}}" type="submit" value="download"/>
            <div class="input-group col-xs-9">
                <label for="{{$result}}">
                    Ergebnis {{$result}}
                </label>
            </div>
        </form>
        @endforeach
    </div>
    <div class="row">
        @if(!empty($results))
        <form action="/results/delete" class="form-horizontal col-xs-6" method="POST">
            {{ csrf_field() }}
            <div class="input-group">
                <label for="delete">
                    Lösche alle ergebnisse
                </label>
                <input class="btn btn-danger btn-block col-xs-12" id="delete" type="submit" value="delete"/>
            </div>
        </form>
        <form action="/" class="form-horizontal col-xs-6" method="GET">
            <div class="input-group">
                <label for="frontpage">
                    Zurück zur Startseite
                </label>
                @else
                <form action="/" class="form-horizontal col-xs-6 method="GET">
                    <div class="input-group">
                        <label for="frontpage">
                            Keine Ergebnisse. Erstelle welche:
                        </label>
                        @endif
                        <input class="btn btn-danger btn-block col-xs-12" id="frontpage" type="submit" value="Zurück"/>
                    </div>
                </form>
            </div>
        </form>
    </div>
    @endsection
</div>