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
                        <label class="col-sm-2 control-label">Descrizione</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="description" placeholder="Descrivi la tua esperienza, come raggiungere il luogo, ecc.">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Tipologia</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="type">
                                <option></option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ $type->id==old('type') ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="disabled" checked="{{ old('disabled') }}"> Accessibile ai disabili
                                </label>
                            </div>
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
