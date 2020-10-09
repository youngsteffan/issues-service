@extends('layouts.app')

@section('title', $ticket->title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                    </div>

                    <div class="card-body">
                        @include('includes.flash')

                        <div class="ticket-info">
                            <p>{{ $ticket->message }}</p>
                            <p>Категория: {{ $category->name }}</p>
                            <p>
                                @if ($status->id === \App\Http\Controllers\TicketsController::CODE_OPEN_REQUEST_STATUS)
                                    Статус: <span class="badge badge-success">{{ $ticket->status->name }}</span>
                                @elseif ($status->id === \App\Http\Controllers\TicketsController::CODE_CLOSED_REQUEST_STATUS)
                                    Статус: <span class="badge badge-danger">{{ $ticket->status->name }}</span>
                                @elseif ($status->id === \App\Http\Controllers\TicketsController::CODE_REOPENED_REQUEST_STATUS)
                                    Статус: <span class="badge badge-primary">{{ $ticket->status->name }}</span>
                                @endif
                            </p>
                            <p>Назначена: <strong>{{ $ticket->assigned_to }}</strong>@if (auth()->user()->name === $ticket->assigned_to) {{ ' (Вы)' }}@endif</p>
                            <p>Создана: {{ $ticket->created_at->diffForHumans() }}</p>
                        </div>

                        <hr>
                        @if ($status->id !== \App\Http\Controllers\TicketsController::CODE_CLOSED_REQUEST_STATUS || auth()->user()->is_admin)
                            <div class="comment-form">
                                <form action="{{ url('comment') }}" method="POST" class="form">
                                    {!! csrf_field() !!}

                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                        <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                                        @if ($errors->has('comment'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Комментировать</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <div class="comments">
                            @foreach ($comments as $comment)
                                <div class="card alert-@if($ticket->user->id === $comment->user_id) {{"default"}}@else{{"success"}}@endif mb-2">
                                    <div class="card card-header">
                                        {{ $comment->user->name }}@if($ticket->user->id === $comment->user_id) {{ '(Owner)' }}@endif
                                        <span class="pull-right">{{ $comment->created_at->format('d.m.Y') }}</span>
                                    </div>

                                    <div class="card card-body">
                                        {{ $comment->comment }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
