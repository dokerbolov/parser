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
        <h2>Программа передач</h2>
        <h5> Время изменения xml: {{ $last_modified_time_xml }} </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="m-3">
                    <h4>XML</h4>
                    <a class="btn btn-primary" href="{{ route('downloadXml') }}">Скачать</a>
                    <a class="btn btn-primary" href="{{ route('updateXml') }}">Обновить xml файл на сервере</a>
                </div>
                <div class="mb-3">
                    <h4>События</h4>
                    <a class="btn btn-primary" href="{{ route('formCreate') }}">Создать</a>
                </div>
            </div>

            <div class="col-md-6">
                <form method="GET" action="{{ route('list') }}">
                    <div class="row">
                        {{--                    <div class="col-md-3">--}}
                        {{--                        <div class="form-group">--}}
                        {{--                            <label for="genre">Жанр</label>--}}
                        {{--                            <select id="genre" name="genre" class="form-control">--}}
                        {{--                                <option value="">Выберите жанр</option>--}}
                        {{--                                @foreach($genres as $genre)--}}
                        {{--                                    <option value="{{ $genre->id }}">{{ $genre->title }}</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="channel">Канал</label>
                                <select id="channel" name="channel" class="form-control">
                                    <option value="">Выберите канал</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}">{{ $channel->id . ' | ' . $channel->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_start">Дата начала</label>
                                <input type="date" id="date_start" name="date_start" class="form-control">
                            </div>
                        </div>
                        {{--                    <div class="col-md-3">--}}
                        {{--                        <div class="form-group">--}}
                        {{--                            <label for="date_end">Дата окончания</label>--}}
                        {{--                            <input type="date" id="date_end" name="date_end" class="form-control">--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Фильтровать</button>
                        <button type="button" id="resetButton" class="btn btn-secondary">Сбросить</button>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>Hash_id</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Картинка</th>
                <th>Канал</th>
                <th>Жанр</th>
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
                    <td>{{ $match->picture    }}</td>
                    <td>{{ $match->channel }}</td>
                    <td>{{ $match->genre }}</td>
                    <td>{{ $match->date_start }}</td>
                    <td>{{ $match->date_end }}</td>
                    <td>
                        <a href="{{ route('formEdit', $match->id) }}" class="btn btn-info">Изменить</a>
                        <form action="{{ route('formDestroy', $match->id) }}" method="POST" class="d-inline"
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

    <script>
        document.getElementById('resetButton').addEventListener('click', function () {
            window.location.href = '{{ route('list') }}';
        });
    </script>
@endsection