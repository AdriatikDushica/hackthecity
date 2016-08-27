@extends('layouts.app')

@section('content')
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ url('/home') }}">Le mie foto</a></li>
            <li class="active">Modifica foto</li>
        </ul>

        <div class="panel panel-default">

            <div class="panel-heading">
                Modifica informazioni foto
            </div>

            <div class="panel-body">

                <div class="row">

                    <div class="col-xs-7">
                        <img src="{{ asset($location->path) }}" class="img-responsive"/>
                    </div>

                    <div class="col-xs-5">
                        <form class="form" method="POST" action="{{ url('home', $location->id) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label>Descrizione</label>
                                <textarea class="form-control">{{ $location->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Tipologia</label>
                                <select class="form-control" name="type">
                                    <option></option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ $type->id==$location->type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" {{ $location->disabled ? 'checked' : '' }}> accessibile hai disabili</label>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Aggiorna informazioni">
                        </form>

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
