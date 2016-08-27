@extends('layouts.app')

@section('content')
    <div class="container">
        
        <ul class="breadcrumb">
            <li><a href="{{ url('/home') }}">Le mie foto</a></li>
            <li class="active">Carica</li>
        </ul>
        
        <div class="panel panel-default">

            <div class="panel-heading">
                Informazioni foto
            </div>

            <div class="panel-body">
                <form method="POST" action="{{ url('home') }}" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="file">
                            @if ($errors->has('file'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('file') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Carica</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
