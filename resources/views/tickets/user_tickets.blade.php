@extends('layouts.app')

@section('title', 'My Requests')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-ticket"> Мои заявки</i>
                    </div>

                    <div class="card-body">
                        @include('includes.flash')
                        @if ($tickets->isEmpty())
                            <p>Вы не создали ни одной заявки</p>
                        @else
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
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>
                                            @foreach ($categories as $category)
                                                @if ($category->id === $ticket->category_id)
                                                    {{ $category->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ url('request/'. strtolower($ticket->ticket_id)) }}">
                                                #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                                            </a>
                                        </td>
                                        <td>
                                            @foreach ($statuses as $status)
                                                @if ($status->id === $ticket->status_id)
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
                                        <td>{{ $ticket->updated_at->format('d.m.Y h:i') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $tickets->render() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
