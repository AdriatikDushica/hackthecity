@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Foto piaciute</div>

            <div class="panel-body">

                @forelse($locations->chunk(3) as $row)
                    <div class="row">
                        @foreach($row as $location)
                            <div class="col-sm-4 text-center" style="margin-bottom: 25px;">
                                <div>
                                    <a href="{{ url('locations', [$location->id]) }}">
                                        <img src="{{ asset($location->path) }}" class="single-photo-gallery">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <h4 class="text-center">Non hai ancora messo mi piace a nessuna foto!</h4>
                @endforelse

                <div class="text-center">{!! $locations !!}</div>

            </div>
        </div>
    </div>
@endsection
