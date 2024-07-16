@extends('layouts.rescuer')

@section('content')
<div class="container my-5 p-3 bg-light rounded shadow-sm">
    <div class="border-bottom pb-2 mb-3">
        <h4>{{ $announcement->user->name }} <small class="text-muted">| {{ $announcement->created_at->format('d M Y,
                H:i') }}</small></h4>
    </div>

    <div class="mb-4">
        <p>{{ $announcement->description }}</p>
    </div>
    <hr>
    @if($announcement->status !='closed')
    <a href="{{ route('rescuer.announcements.close',$announcement->id) }}" class="btn btn-success">Clôtuer</a>
    @endif
    <a href="{{ route('rescuer.home') }}" class="btn btn-outline-secondary">Retour</a>
    <hr>

    <div class="comments-section mb-4">
        @foreach($announcement->comments as $comment)
        <div class="comment mb-3 p-2 border rounded">
            <p>{{ $comment->content }}</p>
            <small class="text-muted">{{ $comment->user->name }} | {{ $comment->created_at->format('d M Y, H:i')
                }}</small>
        </div>
        @endforeach
    </div>
    <div class="comment-form">
        <h5>Rédiger un commentaire</h5>
        <form method="POST" action="{{ route('rescuer.announcements.comment.store', $announcement->id) }}">
            @csrf
            <div class="form-group mb-3">
                <textarea class="form-control" name="content" id="content" rows="5" placeholder="Votre commentaire..."
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</div>
@endsection
