@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Каналы</h1>
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('formCreate') }}">Создать</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>Hash_id</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Канал</th>
                <th>Дата начала</th>
                <th>Дата окончания</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($matches as $match)
                <tr>
                    <td>{{ $match->hash_id }}</td>
                    <td>{{ $match->title }}</td>
                    <td>{{ $match->description }}</td>
                    <td>{{ $match->channel }}</td>
                    <td>{{ $match->date_start }}</td>
                    <td>{{ $match->date_end }}</td>
                    <td>
                        <a href="{{ route('formEdit', $match->id) }}" class="btn btn-info">Изменить</a>
                        <form action="{{ route('formDestroy', $match->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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