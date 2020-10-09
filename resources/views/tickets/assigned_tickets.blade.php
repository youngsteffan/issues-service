@extends('layouts.app')

@section('title', 'Assigned requests')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-ticket"> Ваши заявки</i>
                    </div>

                    <div class="card-body">
                        @include('includes.flash')
                        @if ($assignedTickets->isEmpty())
                            <p>Нет заявок, назначенных на Вас</p>
                        @else
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Категория</th>
                                    <th>Заголовок</th>
                                    <th>Статус</th>
                                    <th>Обновлен</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($assignedTickets as $ticket)
                                    <tr>
                                        <td>
                                            @foreach ($categories as $category)
                                                @if ($category->id === $ticket->category_id)
                                                    {{ $category->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ url('request/'. $ticket->ticket_id) }}">
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
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>
                                            @if ($status->id === \App\Http\Controllers\TicketsController::CODE_OPEN_REQUEST_STATUS || $status->id === \App\Http\Controllers\TicketsController::CODE_REOPENED_REQUEST_STATUS)
                                                <form action="{{ url('admin/request/close/' . $ticket->ticket_id) }}" method="POST">
                                                    {!! csrf_field() !!}
                                                    <button type="submit" class="btn btn-danger">Закрыть</button>
                                                </form>
                                            @endif
                                            @if ($status->id === \App\Http\Controllers\TicketsController::CODE_CLOSED_REQUEST_STATUS)
                                                <form action="{{ url('admin/request/reopen/' . $ticket->ticket_id) }}" method="POST">
                                                    {!! csrf_field() !!}
                                                    <button type="submit" class="btn btn-primary">Переоткрыть</button>
                                                </form>
                                            @endif
                                        </td>
                                        {{--<td><button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#edit-modal" data-category="{{$ticket->category_id}}">Test</button></td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $assignedTickets->render() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                        <label for="category" class="col-md-4 offset-3 control-label">Category</label>

                        <div class="col-md-6 offset-3">
                            <select id="modal-edit-category" type="category" class="form-control" name="category">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('category'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
