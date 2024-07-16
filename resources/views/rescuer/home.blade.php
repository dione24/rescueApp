@extends('layouts.rescuer')
@section('content')
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <th>Description</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>
                            Location
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zonesAnnounces as $announcement)
                        <tr>
                            <td>{{ $announcement->description }}</td>
                            <td>
                                {{ $announcement->user->name }}
                            </td>
                            <td>{{ $announcement->created_at }}</td>
                            <td>
                                <form action="{{ route('rescuer.announcements.accept', $announcement->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">J'accepte</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
