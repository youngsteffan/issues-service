@extends('layouts.app')
@section('title', 'Open Request')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card">
                    <div class="card-header">Создать заявку</div>

                    <div class="card-body">
                        @include('includes.flash')

                        <form role="form" method="POST" action="{{ url('/request/create') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 offset-3 control-label">Заголовок</label>

                                <div class="col-md-6 offset-3">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                <label for="category" class="col-md-4 offset-3 control-label">Категория</label>

                                <div class="col-md-6 offset-3">
                                    <select id="category" type="category" class="form-control" name="category">
                                        <option value="">Выберит категорию</option>
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

                            <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                                <label for="priority" class="col-md-4 offset-3 control-label">Приоритет</label>

                                <div class="col-md-6 offset-3">
                                    <select id="priority" type="priority" class="form-control" name="priority">
                                        <option value="">Выберите приоритет</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('priority'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <label for="message" class="col-md-4 offset-3 control-label">Сообщение</label>

                                <div class="col-md-6 offset-3">
                                    <textarea rows="10" id="message" class="form-control" name="message"></textarea>

                                    @if ($errors->has('message'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-ticket"></i> Создать заявку
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
