@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
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
        <h1>Каналы</h1>
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('ChannelCreate') }}">Создать</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($channels as $channel)
                <tr>
                    <td>{{ $channel->id }}</td>
                    <td>{{ $channel->title }}</td>
                    <td>{{ $channel->description }}</td>
                    <td>
                        <a href="{{ route('channelEdit', $channel->id) }}" class="btn btn-info">Изменить</a>
                        <form action="{{ route('channelDestroy', $channel->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger" type="submit">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection