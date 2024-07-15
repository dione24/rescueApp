@extends('layouts.client')

@section('content')
<div class="container mt-5">
    <h5>Nouvelle Alerte</h5>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('announcements.store') }}" method="POST" id="alertForm" class="p-4">
                        @csrf
                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                required></textarea>
                        </div>

                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">

                        <div class="progress d-none mb-4" id="progressBar">
                            <div class="progress-bar progress-bar-striped progress-bar-animated custom-progress-bar"
                                role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                style="width: 100%"></div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Créer</button>
                    </form>
                </div>
            </div>
            <div id="geoError" class="alert alert-danger mt-3 d-none">
                Erreur de géolocalisation. Veuillez vérifier vos paramètres de localisation et réessayer.
            </div>
        </div>
    </div>
</div>

<style>
    .custom-progress-bar {
        background-color: blue;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const geoError = document.getElementById('geoError');
        const alertForm = document.getElementById('alertForm');
        const progressBar = document.getElementById('progressBar');
        const submitButton = alertForm.querySelector('button[type="submit"]');

        alertForm.addEventListener('submit', function(event) {
            event.preventDefault();

            submitButton.disabled = true; // Disable the submit button
            progressBar.classList.remove('d-none'); // Show the progress bar

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;

                    progressBar.classList.add('d-none'); // Hide the progress bar
                    submitButton.disabled = false; // Enable the submit button
                    alertForm.submit();
                }, function(error) {
                    progressBar.classList.add('d-none'); // Hide the progress bar
                    submitButton.disabled = false; // Enable the submit button

                    geoError.innerText = 'Erreur de géolocalisation : ' + error.message;
                    geoError.style.display = 'block';
                });
            } else {
                progressBar.classList.add('d-none'); // Hide the progress bar
                submitButton.disabled = false; // Enable the submit button

                geoError.innerText = 'Géolocalisation non supportée par ce navigateur.';
                geoError.style.display = 'block';
            }
        });
    });
</script>
@endsection
