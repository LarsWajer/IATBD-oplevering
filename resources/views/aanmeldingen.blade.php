<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aanmelden voor Oppas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Aanmelden voor {{ $huisdier->name }}</h1>
        <p>Wil je je aanmelden om op {{ $huisdier->name }} ({{ $huisdier->ras }}) te passen?</p>

        <form action="{{ route('aanmeldingen.store') }}" method="POST">
            @csrf
            <input type="hidden" name="huisdier_id" value="{{ $huisdier->id }}">
            <button type="submit" class="btn btn-primary">Ja, ik wil oppassen</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</body>
</html>
