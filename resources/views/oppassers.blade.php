<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oppassers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Mijn Laravel App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('oppassers.index') }}">Oppassers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('huisdieren.index') }}">Huisdieren</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="container mt-5">
        <h1>Oppassers Pagina</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if($oppassers->isEmpty())
            <p>Geen oppassers gevonden.</p>
        @else
        <ul class="list-group">
    @foreach($oppassers as $oppasser)
        <li class="list-group-item">
            <h5>{{ $oppasser->name }}</h5>
            @if($oppasser->photo)
                <img src="{{ asset('storage/' . $oppasser->photo) }}" alt="Foto van {{ $oppasser->name }}" style="width: 100px; height: 100px; object-fit: cover;">
            @else
                <p>Geen foto beschikbaar</p>
            @endif

            <!-- Controleer of de oppasser geaccepteerd is -->
            @php
                // Filter de aanmeldingen op basis van is_accepted
                $acceptedCount = $oppasser->aanmeldingen->where('is_accepted', true)->count();
            @endphp
            
            @if($acceptedCount > 0)
                <p><strong>Geaccepteerde oppasser:</strong> Ja</p>
            @else
                <p><strong>Geaccepteerde oppasser:</strong> Nee</p>
            @endif
        </li>
        <!-- Toon review en rating -->
        @if($oppasser->review)
                <p><strong>Review:</strong> {{ $oppasser->review }}</p>
                <p><strong>Rating:</strong> {{ $oppasser->rating }}/5</p>
            
            @endif

            <!-- Reviews weergeven -->
        @if(!empty($oppasser->reviews))
            <h6>Reviews:</h6>
            <ul>
                @foreach($oppasser->reviews as $review)
                    <li>
                        <strong>{{ $review['user'] }}</strong> gaf een beoordeling van <strong>{{ $review['rating'] }}/5</strong>: 
                        <p>{{ $review['review'] }}</p>
                        <small>{{ \Carbon\Carbon::parse($review['created_at'])->diffForHumans() }}</small>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Geen reviews voor deze persoon.</p>
        @endif

        <!-- Formulier voor het plaatsen van een nieuwe review -->
        <form action="{{ route('oppassers.storeReview', $oppasser->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="review" class="form-label">Review</label>
                <textarea class="form-control" id="review" name="review" required></textarea>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select class="form-control" id="rating" name="rating" required>
                    <option value="">Kies een rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Review toevoegen</button>
        </form>
    </li>
@endforeach
</ul>

        @endif

        <!-- Formulier voor het toevoegen van een nieuwe oppasser -->
        <div class="mt-5">
            <h2>Voeg een nieuwe oppasser toe</h2>
            <form action="{{ route('oppassers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="photo" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Toevoegen</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
