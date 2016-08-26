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
                                    <img src="{{ asset($location->path) }}" class="single-photo-gallery">
                                </div>
                                <div class="gallery-actions">
                                    <form method="POST" action="{{ url('home', [$location->id]) }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="submit" class="btn btn-danger" value="delete">
                                    </form>
                                    <a href="#" class="btn btn-default"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
