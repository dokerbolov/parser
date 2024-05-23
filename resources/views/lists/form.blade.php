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
                <input type="text" class="form-control" id="description" name="description"
                       value="{{ old('description') }}">
                @if ($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
                <label for="picture">Картинка</label>
                <input type="text" class="form-control" id="picture" name="picture"
                       value="{{ old('picture') }}">
                @if ($errors->has('picture'))
                    <span class="help-block">
                    <strong>{{ $errors->first('picture') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('channel_id') ? ' has-error' : '' }}">
                <label for="channel_id">Канал</label>
                <select class="form-control" id="channel_id" name="channel_id">
                    <option value="">Выберите канал</option>
                    @foreach($channels as $channel)
                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                            {{ $channel->id . ' | ' . $channel->title }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('channel_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('channel_id') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">
                <label for="genre">Жанр</label>
                <select class="form-control" id="genre" name="genre">
                    <option value="">Выберите жанр</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre') == $genre->id  ? 'selected' : '' }}>
                            {{ $genre->id . ' | ' . $genre->title }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('genre'))
                    <span class="help-block">
                    <strong>{{ $errors->first('genre') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                <label for="date_start">Дата начала</label>
                <input type="datetime-local" class="form-control" id="date_start" name="date_start"
                       value="{{ old('date_start') }}">
                @if ($errors->has('date_start'))
                    <span class="help-block">
                    <strong>{{ $errors->first('date_start') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('date_end') ? ' has-error' : '' }}">
                <label for="date_end">Дата окончания</label>
                <input type="datetime-local" class="form-control" id="date_end" name="date_end"
                       value="{{ old('date_end') }}">
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
