<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huisdieren Beheer</title>
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
                        <a class="nav-link" href="{{ route('aanmeldingen.beheer') }}">Beheer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('oppassers.index') }}">Oppassers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('huisdieren.index') }}">Huisdieren</a>
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
        <h1>Beheer jouw huisdieren</h1>

        <!-- Display status message -->
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form for adding a new pet -->
        <h2>Voeg een nieuw huisdier toe</h2>
        <form action="{{ route('huisdieren.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Naam</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="ras" class="form-label">Dier</label>
                <select class="form-control" id="ras" name="ras" required>
                    <option value="" disabled selected>Kies een dier</option>
                    <option value="hond">Hond</option>
                    <option value="kat">Kat</option>
                    <option value="vis">Vis</option>
                    <option value="konijn">Konijn</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="geld" class="form-label">Wat is het uurloon?</label>
                <input type="number" class="form-control" id="geld" name="geld" min="0" step="0.01" placeholder="Bijvoorbeeld: 10.50" required>
            </div>

            <div class="mb-3">
                <label for="informatie" class="form-label">Vertel wat informatie over je huisdier en hoelang je een oppasser wilt</label>
                <input type="text" class="form-control" id="informatie" name="informatie">
            </div>

            <!-- Foto upload veld onder het ras -->
            <div class="mb-3">
                <label for="photo" class="form-label">Voeg een foto van je huisdier toe</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            </div>

            

            <button type="submit" class="btn btn-primary">Huisdier Toevoegen</button>
        </form>

        <!-- Display the list of pets -->
        <h2 class="mt-5">Jouw Huisdieren</h2>
        @if($huisdieren->isEmpty())
            <p>Je hebt nog geen huisdieren toegevoegd.</p>
        @else
            <ul class="list-group">
            @foreach($huisdieren as $huisdier)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $huisdier->name }}</h5>
                        <p class="card-text"><strong>Dier:</strong> {{ $huisdier->ras }}</p>
                        <p class="card-text"><strong>Uurloon:</strong> {{ $huisdier->geld }}</p>
                        @if($huisdier->photo)
                            <img src="{{ asset('storage/' . $huisdier->photo) }}" alt="Foto van {{ $huisdier->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <p>Geen foto beschikbaar</p>
                        @endif
                        <p class="card-text"><strong>Informatie over dier:</strong> {{ $huisdier->informatie }}</p>
                
                        <!-- Verwijderknop voor het huisdier -->
                        <form action="{{ route('huisdieren.destroy', $huisdier->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Verwijderen</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            </ul>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
