@extends('layouts.app')
@section('content')

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Liste des Formations
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
                        <div class="">
                            <a href="{{ route('admin.formation.create') }}" class="btn btn-primary"> Create</a>
                        </div>
                        <br /><br />


                        <table class="table table-hover text-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($formations as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>{{ $course->titre }}</td>
                                    <td>{{ $course->created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            <a href="{{ route('admin.formation.show', $course->id) }}"
                                                class="btn btn-secondary btn-sm">
                                                <i class="fa fa-edit"></i> Voir
                                            </a>

                                            <a href="{{ route('admin.formation.edit', $course->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            &ensp;
                                            <form action="{{ route('admin.formation.destroy', $course->id) }}"
                                                method="post" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
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
