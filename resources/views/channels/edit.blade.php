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
        <h1>Изменение</h1>
        <form action="{{ route('channelUpdate', $channel->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="POST">
            <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="{{ old('id', $channel->id) }}">
                @if ($errors->has('id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('id') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title"
                       value="{{ old('title', $channel->title) }}">
                @if ($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                       value="{{ old('description', $channel->description) }}">
                @if ($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Изменить</button>
        </form>
    </div>
@endsection
