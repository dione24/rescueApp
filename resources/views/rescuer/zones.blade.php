@extends('layouts.rescuer')
@section('content')

<br>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Mes Zones
                </h3>

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
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>User</th>
                            <th>
                                Action
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zones as $zone)
                        <tr>
                            <td>
                                {{$zone->id}}
                            </td>
                            <td>
                                {{$zone->name}}
                            </td>
                            <td>
                                {{$zone->user->name}}
                            </td>
                            <td>

                                <form action="{{route('coverage_zone.destroy',$zone->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
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
