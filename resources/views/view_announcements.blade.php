<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir les Annonces</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Voir les Annonces</h1>
        @foreach ($announcements as $announcement)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Annonce #{{ $announcement->id }}</h5>
                <p class="card-text">{{ $announcement->description }}</p>
                <p class="card-text">
                    <small class="text-muted">Latitude: {{ $announcement->latitude }}</small><br>
                    <small class="text-muted">Longitude: {{ $announcement->longitude }}</small>
                </p>
                <p>
                    {{ $announcement->created_at->diffForHumans() }} By {{ $announcement->user->name }}
                </p>
                <form action="{{ route('announcements.accept', $announcement->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Accepter</button>
                </form>
            </div>
        </div>
        @endforeach