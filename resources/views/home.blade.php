@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card">
        <div class="card-header">Dashboard</div>
          <div class="card-body">

            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            Estás autenticado como:

            @if(Auth::user()->hasRole('admin'))
              administrador
            @else
              usuario normal
            @endif

          </div><!-- /.card-body -->
        </div><!-- /.card -->

      </div><!-- /.col -->
    </div><!-- /.row -->

</div><!-- /.container -->
@endsection
