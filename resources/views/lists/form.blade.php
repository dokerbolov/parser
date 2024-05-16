@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1>Создание</h1>
        <form action="{{ route('submitForm') }}" method="POST">
            {!! csrf_field() !!}
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">Название</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                @if ($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description">Описание</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
                @if ($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('channel_id') ? ' has-error' : '' }}">
                <label for="channel_id">Канал</label>
                <input type="text" class="form-control" id="channel_id" name="channel_id" value="{{ old('channel_id') }}">
                @if ($errors->has('channel_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('channel_id') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                <label for="date_start">Дата начала</label>
                <input type="date" class="form-control" id="date_start" name="date_start" value="{{ old('date_start') }}">
                @if ($errors->has('date_start'))
                    <span class="help-block">
                    <strong>{{ $errors->first('date_start') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('date_end') ? ' has-error' : '' }}">
                <label for="date_end">Дата окончания</label>
                <input type="date" class="form-control" id="date_end" name="date_end" value="{{ old('date_end') }}">
                @if ($errors->has('date_end'))
                    <span class="help-block">
                    <strong>{{ $errors->first('date_end') }}</strong>
                </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
@endsection
