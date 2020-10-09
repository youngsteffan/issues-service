@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <p>Вы успешно авторизованы!</p>

                        @if (auth()->user()->is_admin)
                            <p>
                                Смотреть все <a href="{{ url('admin/requests') }}">заявки</a>
                            </p>
                        @else
                            <p>
                                Просмотреть открытые <a href="{{ url('requests') }}">заявки</a> или <a href="{{ url('request/create') }}">открыть новую заявку</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
