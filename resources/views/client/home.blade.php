@extends('layouts.client')

@section('content')
<div class="container my-5 p-3 bg-light rounded shadow-sm">
    <div class="border-bottom pb-2 mb-3">
        <h4>Mes Alertes</h4>
    </div>

    <div class="d-flex flex-wrap">
        @foreach($announcements as $announcement)
        @php
        $cardClass = 'bg-secondary'; // Par défaut pour le statut 'pending'

        if ($announcement->status === 'accepted') {
        $cardClass = 'bg-success';
        } elseif ($announcement->status === 'rejected') {
        $cardClass = 'bg-danger';
        }
        @endphp

        <div class="card text-white {{ $cardClass }} mb-3 me-3" style="max-width: 20rem;">
            <div class="card-header">Statut: {{ ucfirst($announcement->status) }}</div>
            <div class="card-body">
                <h5 class="card-title">{{ $announcement->title }}</h5>
                <p class="card-text">{{ Str::limit($announcement->description, 100) }}</p>
                <a href="{{ route('client.announcements.show', $announcement->id) }}" class="btn btn-light">Voir
                    plus</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
