@extends('layouts.app')

@section('content')
<div class="container">

  @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
  @endif

  <div class="row">
    <div class="col-md-3">

      <div class="card">
        <div class="card-header">Mis roles asignados</div>
          <div class="card-body p-2">
            @foreach(Auth::user()->roles as $rol)
              <span class="badge badge-primary"><i class="fa fa-check"></i> {{ $rol->name }}</span>
            @endforeach
          </div><!-- /.card-body -->
        </div><!-- /.card -->

      </div><!-- /.col -->
    </div><!-- /.row -->

</div><!-- /.container -->
@endsection
