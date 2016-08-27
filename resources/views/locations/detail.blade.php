@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="panel panel-default">

            <div class="panel-heading">
                Dettagli foto

                @if(Auth::check())
                    <div class="pull-right">
                        @if(Auth::user()->likes->where('id', '=', $location->id)->count())
                            <a href="{{ url('locations/'.$location->id.'/like') }}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="rimuovi mi piace">
                                {{ $location->usersLike->count() }}
                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                            </a>
                        @else
                            <a href="{{ url('locations/'.$location->id.'/like') }}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="mi piace">
                                {{ $location->usersLike->count() }}
                                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                @endif
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
                                    <div class="text-success">
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <label>accessibile ai disabili</label>
                                    </div>
                                @else
                                    <div class="text-danger">
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <label>non accessibile ai disabili</label>
                                    </div>
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
