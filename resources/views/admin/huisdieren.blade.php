@extends('layouts.admin')

@section('content')
    <h1>Alle Huisdieren</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Ras</th>
                <th>Eigenaar</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($huisdieren as $huisdier)
                <tr>
                    <td>{{ $huisdier->name }}</td>
                    <td>{{ $huisdier->ras }}</td>
                    <td>{{ $huisdier->user->name ?? 'Onbekend' }}</td> <!-- Relatie met de user -->
                    <td>
                        <form action="{{ route('admin.deleteHuisdier', $huisdier->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit huisdier wilt verwijderen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
