@extends('layouts.rescuer')
@section('content')
<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">
                {{ $formation->titre }}
            </h1>
            <p class="lead text-body-secondary">
                {{ $formation->contenu }}
            </p>
            <p>
                <img src="{{ asset('storage/images/'.$formation->image) }}" alt="image" width="100%">
            </p>

        </div>
    </div>
</section>

@endsection
