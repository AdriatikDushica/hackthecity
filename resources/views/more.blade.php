@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Foto caricate da:</div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-3">
                        <div>
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" class="img-circle">
                            @endif
                            {{ $user->name }}
                        </div>
                    </div>
                    <div class="col-sm-9">
                        @forelse($locations->chunk(3) as $row)
                            <div class="row">
                                @foreach($row as $location)
                                    <div class="col-sm-4 text-center" style="margin-bottom: 25px;">
                                        <div>
                                            <a href="{{ url('locations', [$location->id]) }}">
                                                <img src="{{ asset($location->path) }}" class="single-photo-gallery img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <h4 class="text-center">Non ha caricato nessuna foto</h4>
                        @endforelse
                    </div>
                </div>

                @if($locations->count())
                    <div class="text-center">{!! $locations !!}</div>
                @endif

            </div>
        </div>
    </div>
@endsection
