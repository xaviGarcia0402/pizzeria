@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-8">

      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      <div id="card-roles" class="card">
        <div class="card-header">
          <div class="btn-group float-right btn-group-xs my-n2 mr-n2">
            <a href="{{ route('roles.create') }}" class="btn btn-primary float-right "><i class="fa fa-plus"></i> Nuevo</a>
          </div><!-- /.btn-group -->
          Roles
        </div><!-- /.card-header -->

        <table class="table table-hover table-striped table-sm mb-0">
          <thead>
            <tr>
              <td>Nombre</td>
              <td>Descripción</td>
              <td>Usuarios</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $rol)
              <tr>
                <td class="align-middle">{{ $rol->name }}</td>
                <td class="align-middle">{{ $rol->description }}</td>
                <td>{{ $rol->users()->count() }}</td>
                <td style="width: 120px;">
                  <a href="{{ route('roles.edit', ['role'=>$rol->id]) }}" class="btn btn-primary btn-sm">Editar</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="overlay" style="display: none;"><i class="fa fa-2x fa-refresh fa-spin"></i></div>

      </div><!-- /.card -->

    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->
@endsection
