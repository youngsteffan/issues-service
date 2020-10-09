<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Информация</title>
</head>
<body>
<p>
    Спасибо {{ ucfirst($user->name) }}, что воспользовались нашим веб-сервисом. Заявка была успешна создана. При любых обновлениях на Ваш email адрес будет отправлено оповещение. <br>Детали вашей заявки:
</p>

<p><strong>Заголовок:</strong> {{ $ticket->title }}</p>
<p><strong>Приоритет:</strong> {{ $ticket->priority->name }}</p>
<p><strong>Статус:</strong> {{ $ticket->status->name }}</p>

<p>
    Вы можете посмотреть свою заявку в любое время <a href="{{ url('request/'. $ticket->ticket_id) }}">{{ url('request/'. $ticket->ticket_id) }}</a>
</p>

</body>
</html>
