@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <h1>Создание</h1>
        <form action="{{ route('channelSubmitForm') }}" method="POST">
            {!! csrf_field() !!}
            <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                <label for="title">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="{{ old('id') }}">
                @if ($errors->has('id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('id') }}</strong>
                </span>
                @endif
            </div>
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
                <input type="text" class="form-control" id="description" name="description"
                       value="{{ old('description') }}">
                @if ($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
@endsection
