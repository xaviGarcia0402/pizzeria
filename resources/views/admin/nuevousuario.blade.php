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
          Nuevo usuario
        </div><!-- /.card-header -->
        <div class="card-body">
          <form class="" action="{{ url('admin/usuarios') }}" method="post">
             {{ csrf_field() }}
            <div class="form-group row">
      				<label class="col-sm-3 col-form-label text-sm-right">Usuario</label>
      				<div class="col-sm-9">
      					<input type="text" class="form-control" placeholder="ej. gmartin" name="username" maxlength="20">
      				</div><!-- /.col -->
      			</div><!-- /.form-group row -->
            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-sm-right">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" name="email" maxlength="254">
              </div><!-- /.col -->
            </div><!-- /.form-group row -->
            <div class="form-group row">
      				<label class="col-sm-3 col-form-label text-sm-right">Contraseña</label>
      				<div class="col-sm-9">
      					<input type="text" class="form-control" name="password">
      				</div><!-- /.col -->
      			</div><!-- /.form-group -->
            <hr>
            <div class="form-group row">
              <div class="col-sm-4 mx-auto">
                <button id="btn-guardar_usuario" type="submit" class="btn btn-outline-primary btn-block">Guardar</button>
              </div><!-- /.col -->
            </div><!-- /.form-group -->
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->

    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->
@endsection
