<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navigatiebalk -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">PassenOpJeDier</a>
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
                        <a class="nav-link" href="{{ route('aanmeldingen.beheer') }}">Beheer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('oppassers.index') }}">Oppassers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('huisdieren.index') }}">Huisdieren</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
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
        @auth
            <h1>Welkom {{ auth()->user()->name }}</h1>
            <p>Je bent ingelogd!</p>
        @else
            <h1>Welkom bij PassenOpJeDier</h1>
            <p>Log in of registreer om door te gaan.</p>
        @endauth

        <!-- Filter Formulier -->
        <form action="{{ route('home') }}" method="GET" class="mb-5">
            <div class="row">
                <div class="col-md-6">
                    <label for="animal_type" class="form-label">Filter op dier</label>
                    <select name="animal_type" id="animal_type" class="form-control">
                        <option value="">Alle dieren</option>
                        <option value="hond" {{ request('animal_type') == 'hond' ? 'selected' : '' }}>Hond</option>
                        <option value="kat" {{ request('animal_type') == 'kat' ? 'selected' : '' }}>Kat</option>
                        <option value="vis" {{ request('animal_type') == 'vis' ? 'selected' : '' }}>Vis</option>
                        <option value="konijn" {{ request('animal_type') == 'konijn' ? 'selected' : '' }}>Konijn</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="price_range" class="form-label">Filter op prijs</label>
                    <select name="price_range" id="price_range" class="form-control">
                        <option value="">Alle prijzen</option>
                        <option value="0-10" {{ request('price_range') == '0-10' ? 'selected' : '' }}>€0.00 - €10.00</option>
                        <option value="10-20" {{ request('price_range') == '10-20' ? 'selected' : '' }}>€10.00 - €20.00</option>
                        <option value="20-30" {{ request('price_range') == '20-30' ? 'selected' : '' }}>€20.00 - €30.00</option>
                    </select>
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Reset</a> <!-- Reset button -->
                </div>
            </div>
        </form>

        <!-- Gefilterde Huisdieren -->
        <div class="row mt-5">
            @if($huisdieren->isEmpty())
                <p>Geen huisdieren gevonden voor de opgegeven filters.</p>
            @else
            @foreach($huisdieren as $huisdier)
    @if(!$huisdier->aanmeldingen->where('is_accepted', true)->count())
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

                    <a href="{{ route('aanmeldingen.create', ['huisdier_id' => $huisdier->id]) }}" class="btn btn-success">Ik wil oppassen!</a>
                </div>
            </div>
        </div>
    @endif
@endforeach

            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
