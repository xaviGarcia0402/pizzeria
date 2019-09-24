@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card">
        <div class="card-header">
          @if($modo=="nuevo")
            Nuevo usuario
          @else
            Editar usuario
          @endif
        </div><!-- /.card-header -->
        <div class="card-body">
          <form action="{{ $modo == 'nuevo' ? route('usuarios.store') : route('usuarios.update', ['usuario'=>$user->id]) }}" method="POST">
            {{ csrf_field() }}
            @if($modo=="editar") @method('PUT') @endif
            <div class="form-group row">
      				<label class="col-sm-3 col-form-label text-sm-right">Usuario</label>
      				<div class="col-sm-9">
      					<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" maxlength="254" value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      				</div><!-- /.col -->
      			</div><!-- /.form-group row -->
            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-sm-right">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" maxlength="254" value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div><!-- /.col -->
            </div><!-- /.form-group row -->
            <div class="form-group row">
      				<label class="col-sm-3 col-form-label text-sm-right">Contraseña</label>
      				<div class="col-sm-9">
      					<input type="text" class="form-control @error('password') is-invalid @enderror" name="password" maxlength="254" value="{{ old('password') }}" @if($modo=="nuevo") required @else placeholder="SOLO LLENAR SI SE DESEA EDITAR" @endif>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
