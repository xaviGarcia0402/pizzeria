@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card">
        <div class="card-header">
          {{ $modo == 'nuevo' ? 'Nuevo' : 'Editar' }} rol
        </div><!-- /.card-header -->
        <div class="card-body">
          <form action="{{ $modo == 'nuevo' ? route('roles.store') : route('roles.update', ['role'=>$rol->id]) }}" method="POST">
            {{ csrf_field() }}
            @if($modo=="editar") @method('PUT') @endif
            <div class="form-group row">
      				<label class="col-sm-3 col-form-label text-sm-right">Nombre</label>
      				<div class="col-sm-9">
      					<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" maxlength="254" value="{{ old('name', $rol->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      				</div><!-- /.col -->
      			</div><!-- /.form-group row -->
            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-sm-right">Descripción</label>
              <div class="col-sm-9">
                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" maxlength="254" value="{{ old('description', $rol->description) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div><!-- /.col -->
            </div><!-- /.form-group row -->
            <hr>
            <div class="form-group row">
              <div class="col-sm-4 mx-auto">
                <button id="btn-guardar" type="submit" class="btn btn-outline-primary btn-block">Guardar</button>
              </div><!-- /.col -->
            </div><!-- /.form-group -->
          </form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->

    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->
@endsection
