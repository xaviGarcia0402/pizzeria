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

      <div class="card">
        <div class="card-header">
          Usuarios
        </div><!-- /.card-header -->

        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <td>User</td>
              <td>Email</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td style="width: 150px;">
                  <button type="button" class="btn btn-primary btn-sm">Editar</button>
                  <button type="button" class="btn btn-warning btn-sm">Borrar</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        </div><!-- /.card -->

    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->
@endsection
