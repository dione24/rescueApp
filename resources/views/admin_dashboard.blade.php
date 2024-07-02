<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Tableau de Bord Admin</h1>
        <h2>Utilisateurs</h2>
        <ul>
            @foreach ($users as $user)
            <li>{{ $user->name }} ({{ $user->email }})</li>
            @endforeach
        </ul>

        <h2>Annonces</h2>
        <ul>
            @foreach ($announcements as $announcement)
            <li>
                Annonce #{{ $announcement->id }}: {{ $announcement->description }}
                @if($announcement->status == 'accepted')
                <span class="badge bg-success">Acceptée</span>
                @else
                <span class="badge bg-warning">En attente</span>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</body>

</html>