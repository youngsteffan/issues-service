<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Статус</title>
</head>
<body>
<p>
    Здравствуйте, {{ ucfirst($ticketOwner->name) }},
</p>
<p>
    @if ($ticket->status_id === \App\Http\Controllers\TicketsController::CODE_CLOSED_REQUEST_STATUS)
    Ваша заявка с идентификатором #{{ $ticket->ticket_id }} была успешно решена и закрыта.
        @elseif ($ticket->status_id === \App\Http\Controllers\TicketsController::CODE_REOPENED_REQUEST_STATUS)
        Ваша заявка с идентификатором #{{ $ticket->ticket_id }} была переоткрыта.
    @endif
</p>

<p>
    Вы можете посмотреть свою заявку в любое время <a href="{{ url('request/'. $ticket->ticket_id) }}">{{ url('request/'. $ticket->ticket_id) }}</a>
</p>
</body>
</html>
