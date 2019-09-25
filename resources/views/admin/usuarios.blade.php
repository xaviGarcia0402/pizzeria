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

      <div id="card-usuarios" class="card">
        <div class="card-header">
          <div class="btn-group float-right btn-group-xs my-n2 mr-n2">
            @if ($activos)
              <a href="{{ route('usuarios.create') }}" class="btn btn-primary float-right "><i class="fa fa-plus"></i> Nuevo</a>
            @else
              <a href="{{ route('usuarios.index') }}" class="btn btn-primary float-right "><i class="fa fa-chevron-left"></i> Volver a activos</a>
            @endif
            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route('usuarios.inactivos') }}"><i class="fa fa-group" aria-hidden="true"></i> Ver inactivos</a>
            </div>
          </div><!-- /.btn-group -->
          Usuarios
        </div><!-- /.card-header -->

        <table class="table table-hover table-striped table-sm mb-0">
          <thead>
            <tr>
              <td>User</td>
              <td>Email</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr class="{{ $user->activo ? '' : 'table-warning' }}">
                <td class="align-middle">{{ $user->name }}</td>
                <td class="align-middle">{{ $user->email }}</td>
                <td style="width: 120px;">
                  <a href="{{ route('usuarios.edit', ['usuario'=>$user->id]) }}" class="btn btn-primary btn-sm">Editar</a>
                  <button type="button" class="btn btn-status btn-light btn-sm" title="Dar de {{ $user->activo ? 'baja' : 'alta' }}" data-toggle="tooltip" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-activo="{{ $user->activo }}">
                    <i class="fa fa-fw fa-{{ $user->activo ? 'arrow-down' : 'arrow-up' }}"></i>
                  </button>
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

@section('footer_scripts')
  <script type="text/javascript">

    window.addEventListener('load', function(){
      $('[data-toggle="tooltip"]').tooltip({placement:'bottom'});
      $('button.btn-status').click(function(){
        statusToggle(this);
      });

    });

    function statusToggle(target){
      var id = $(target).data('id');
      var name = $(target).data('name');
      var activo = parseInt( $(target).data('activo') );
      var tipo = activo ? 'baja' : 'alta';

      if(! confirm('¿Seguro que deseas dar de ' + tipo + ' al usuario '+name+'?')){ return; }
      $.ajax({
  	    type: 'POST',
  	    cache: false,
  	    url: '/admin/usuarios/cambiar_status',
  	    data: {
  				"id": id,
  				"activo": activo,
  			},
  	    beforeSend: function(){
          $("#card-usuarios .overlay").show();
  	    },
  	    error: function(){
          $("#card-usuarios .overlay").hide();
          alert("Error");
  	    },
  	    success: function(x){
  				x = $.trim(x);
          $("#card-usuarios .overlay").hide();
  				if(x.substr(0,2) == "ok"){
            window.location.reload();
  	      }
  	      else{
            alert(x);
          }
  	    }// /success
  	  });// /ajax
    }// /statusToggle

  </script>
@endsection
