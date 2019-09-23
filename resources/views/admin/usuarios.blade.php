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
          <div class="btn-group float-right btn-group-xs my-n2 mr-n2">
            <a href="{{ route('admin.nuevousuario') }}" class="btn btn-primary float-right "><i class="fa fa-plus"></i> Nuevo</a>
            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#"><i class="fa fa-group" aria-hidden="true"></i> Ver inactivos</a>
            </div>
          </div><!-- /.btn-group -->
          Usuarios
        </div><!-- /.card-header -->

        <table class="table table-hover table-sm mb-0">
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
                <td class="align-middle">{{ $user->name }}</td>
                <td class="align-middle">{{ $user->email }}</td>
                <td style="width: 120px;">
                  <button type="button" class="btn btn-primary btn-sm">Editar</button>
                  <button type="button" class="btn btn-light btn-sm" title="Dar de baja" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
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

@section('footer_scripts')
  <script type="text/javascript">
    window.addEventListener('load', function() {
      $('[data-toggle="tooltip"]').tooltip({placement:'bottom'});
    });
  </script>
@endsection
