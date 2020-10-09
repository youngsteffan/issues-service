@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-search" aria-hidden="true"></i> Результы поиска
                    </div>

                    <div class="card-body">
                        @if ($searchResults->isEmpty())
                            <p>По вашему запросу "{{Request::get('query')}}" ничего не найдено</p>
                            <a href="{{ url()->previous() }}" class="btn btn-link"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Назад</a>
                        @else
                            <a href="{{ url()->previous() }}" class="btn btn-link"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Назад</a>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Категория</th>
                                    <th>Заголовок</th>
                                    <th>Статус</th>
                                    <th>Обновлен</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($searchResults as $searchResult)
                                    <tr>
                                        <td>
                                            @foreach ($categories as $category)
                                                @if ($category->id === $searchResult->category_id)
                                                    {{ $category->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ url('request/'. strtolower($searchResult->ticket_id)) }}">
                                                #{{ $searchResult->ticket_id }} - {{ $searchResult->title }}
                                            </a>
                                        </td>
                                        <td>
                                            @foreach ($statuses as $status)
                                                @if ($status->id === $searchResult->status_id)
                                                    @if ($status->id === \App\Http\Controllers\TicketsController::CODE_OPEN_REQUEST_STATUS)
                                                        <span class="badge badge-success">{{ $status->name }}</span>
                                                        @break
                                                    @elseif ($status->id === \App\Http\Controllers\TicketsController::CODE_CLOSED_REQUEST_STATUS)
                                                        <span class="badge badge-danger">{{ $status->name }}</span>
                                                        @break
                                                    @elseif ($status->id === \App\Http\Controllers\TicketsController::CODE_REOPENED_REQUEST_STATUS)
                                                        <span class="badge badge-primary">{{ $status->name }}</span>
                                                        @break
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $searchResult->updated_at->format('d.m.Y h:i') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $searchResults->render() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
