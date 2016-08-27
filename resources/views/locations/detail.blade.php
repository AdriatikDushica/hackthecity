@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="panel panel-default">

            <div class="panel-heading">
                Dettagli foto

                <div class="pull-right"><b>0</b> mi piace</div>
            </div>

            <div class="panel-body">

                <div class="row">

                    <div class="col-xs-7">
                        <img src="{{ asset($location->path) }}" class="img-responsive"/>
                        <div style="margin-top: 10px;" class="pull-right">
                            Altre foto da <a href="{{ url('more', [$location->user->id]) }}">{{ $location->user->name }}</a>
                        </div>
                    </div>

                    <div class="col-xs-5">
                        <div>
                            <label>Descrizione</label>
                            @if($location->description)
                                <p>{{ $location->description }}</p>
                            @else
                                <p>nessuna descrizione</p>
                            @endif
                            <div>
                                <label>Tipologia</label>
                                <p>{{ $location->type->name }}</p>
                            </div>
                            <div>
                                @if($location->disabled)
                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                    <label>accessibile hai disabili</label>
                                @else
                                    <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                    <label>non accessibile hai disabili</label>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

                <div style="margin-top: 25px;">
                    <label>Luogo in cui è stata scattata la foto</label>
                    <div id="map-detail"></div>
                </div>

            </div>
        </div>
    </div>
@endsection
