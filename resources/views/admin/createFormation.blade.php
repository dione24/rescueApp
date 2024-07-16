@extends('layouts.app')
@section('content')

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Rédiger une Formation
                        </h3>
                    </div>
                    <form method="POST" action="{{ route('admin.formation.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class=" card-body">
                            <div class="form-group">
                                <label for="exampleInputBorder">Titre</label>
                                <input type="text" class="form-control form-control-border" id="exampleInputBorder"
                                    name="titre" placeholder="Titre">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputBorder">Image</label>
                                <input type="file" class="form-control form-control-border" id="exampleInputBorder"
                                    placeholder=".form-control-border" name="image">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputBorder">Content</label>
                                <textarea class="form-control" width="100%" name="contenu" id="content">

                            </textarea>
                            </div>


                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>

                    </form>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
