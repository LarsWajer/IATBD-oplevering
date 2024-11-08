<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aanmeldingen Beheer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

   <!-- Navigatiebalk -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">PassenOpJeDier</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">Profiel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aanmeldingen.beheer') }}">Aanmeldingen Beheer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('huisdieren.index') }}">Huisdieren</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('oppassers.index') }}">Oppassers</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button class="nav-link btn btn-link" type="submit">Uitloggen</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Inloggen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registreren</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>


    <div class="container mt-5">
        <h1>Aanmeldingen Beheer</h1>

        <div class="row mt-5">
            @foreach($huisdieren as $huisdier)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $huisdier->name }}</h5>
                            <p class="card-text"><strong>Dier:</strong> {{ $huisdier->ras }}</p>
                            <p class="card-text"><strong>Uurloon:</strong> €{{ number_format($huisdier->geld, 2) }}</p>
                            @if($huisdier->photo)
                                <img src="{{ asset('storage/' . $huisdier->photo) }}" alt="Foto van {{ $huisdier->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <p>Geen foto beschikbaar</p>
                            @endif

                            <h6>Aanmeldingen:</h6>
                            @foreach($huisdier->aanmeldingen as $aanmelding)
                                <div class="d-flex justify-content-between align-items-center">
                                    <p>{{ $aanmelding->user->name }}</p>
                                    @if($aanmelding->is_accepted)
                                        <span class="text-success">Geaccepteerd</span>
                                    @else
                                        <form action="{{ route('aanmeldingen.accept', $aanmelding->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">✔️</button>
                                        </form>
                                        <form action="{{ route('aanmeldingen.reject', $aanmelding->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">❌</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
