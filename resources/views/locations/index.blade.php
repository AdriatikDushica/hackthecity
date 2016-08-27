@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Le mie foto</div>

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
                                <div class="gallery-actions">
                                    <form method="POST" action="{{ url('home', [$location->id]) }}" id="delete-foto-form">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-foto-form').submit();"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <h5 class="text-center">Non sono presenti foto</h5>
                @endforelse

                <div class="text-center">{!! $locations !!}</div>

            </div>
        </div>
    </div>
@endsection
