@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Album</div>

            <div class="panel-body">

                <div>
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" class="img-circle">
                    @endif
                    {{ $user->name }}
                </div>

                <hr>

                @forelse($locations->chunk(3) as $row)
                    <div class="row">
                        @foreach($row as $location)
                            <div class="col-sm-4 text-center" style="margin-bottom: 25px;">
                                <div>
                                    <a href="{{ url('locations', [$location->id]) }}">
                                        <img src="{{ asset($location->path) }}" class="single-photo-gallery img-thumbnail">
                                    </a>
                                </div>
                                <div class="gallery-actions">
                                    <a href="{{ url('home/'.$location->id.'/edit') }}" class="btn btn-default"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <form method="POST" action="{{ url('home/'.$location->id) }}" style="display: inline">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <h4 class="text-center">Non sono presenti foto</h4>
                @endforelse

                <div class="text-center">{!! $locations !!}</div>

            </div>
        </div>
    </div>
@endsection
