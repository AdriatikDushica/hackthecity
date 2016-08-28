@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="panel panel-default">

            <div class="panel-heading">
                Dettagli foto
            </div>

            <div class="panel-body">

                <div class="row">

                    <div class="col-sm-7">
                        <img src="{{ asset($location->path) }}" class="img-responsive"/>
                    </div>

                    <div class="col-sm-5">
                        <div style="margin-top: 10px;">
                            @if($location->user->avatar)
                                <img class="img-circle" src="{{ $location->user->avatar }}">
                            @endif
                            <a href="{{ url('more/'.$location->user->id) }}">{{ $location->user->name }}</a>

                            <div class="pull-right">
                                @if(Auth::check())
                                    @if(Auth::user()->likes->where('id', '=', $location->id)->count())
                                        <a href="{{ url('locations/'.$location->id.'/like') }}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="rimuovi mi piace">
                                            {{ $location->usersLike->count() }}
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        </a>
                                    @else
                                        <a href="{{ url('locations/'.$location->id.'/like') }}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="mi piace">
                                            {{ $location->usersLike->count() }}
                                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @endif
                                <a target="_blank" href="https://maps.google.com?saddr=Current+Location&daddr={{ $location->lat }},{{ $location->lng }}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="indicazioni stradali"><i class="fa fa-car" aria-hidden="true"></i></a>
                            </div>
                        </div>

                        <hr>

                        <div style="margin-top: 25px;">
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
                            <div style="background-color: #e8e8e8; padding: 10px;">
                                <label>Commenti:</label>
                                @forelse($location->comments as $comment)
                                    <div>
                                        <div>
                                            <a href="{{ url('more/'.$comment->user_id) }}">{{ $comment->user->name }}</a>
                                            @if(Auth::check())
                                                @if(Auth::user()->id==$comment->user_id)
                                                    <a href="{{ url('locations/'.$comment->id.'/delete') }}" class="pull-right" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                @endif
                                            @endif
                                        </div>
                                        <p>{{ $comment->text }}</p>
                                    </div>
                                @empty
                                    <p>Non sono presenti commenti</p>
                                @endif
                                @if(Auth::check())
                                    <form action="{{ url('locations/'.$location->id.'/comment') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Inserisci il tuo commento...." name="text" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit">Commenta!</button>
                                            </span>
                                        </div><!-- /input-group -->
                                    </form>
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
