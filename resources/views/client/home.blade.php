@extends('layouts.client')
@section('content')
<div class="my-5 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">Mes Alertes</h6>
    <br>
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
                <h4 class="card-title">{{ $announcement->title }}</h4>
                <p class="card-text">{{ $announcement->description }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
