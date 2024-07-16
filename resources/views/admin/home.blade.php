@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            {{ $annoncesAttente}}
                        </h3>
                        <p>
                            Alerte en Attentes
                        </p>
                    </div>

                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            {{ $annoncesAccepte}}

                        </h3>
                        <p>
                            Alertes Acceptés
                        </p>
                    </div>

                </div>
            </div>
            <!-- ./col -->

            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $rescuers }}</h3>
                        <p>Secouristes</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Liste des Annonces
                        </h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

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
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Action
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($announcements as $announcement)
                                <tr>
                                    <td>
                                        {{$announcement->id}}
                                    </td>
                                    <td>
                                        {{$announcement->user->name}}
                                    </td>
                                    <td>
                                        {{$announcement->created_at}}
                                    </td>
                                    <td>
                                        {{$announcement->description}}
                                    </td>
                                    <td>

                                        @if($announcement->status == 'accepted')
                                        <span class="badge bg-success">Acceptée</span>
                                        @elseif($announcement->status == 'pending')
                                        <span class="badge bg-warming">En attente</span>
                                        @else
                                        <span class="badge bg-danger">Nouveau</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{route('announcements.destroy',$announcement->id)}}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
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
    </div><!-- /.container-fluid -->
</section>


@endsection
