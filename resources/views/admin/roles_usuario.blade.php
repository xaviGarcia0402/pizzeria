@extends('layouts.app')

@section('content')

<div class="modal fade" id="modal_agregar_rol" tabindex="-1" role="dialog" aria-labelledby="modal_agregar_rolLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-agregar_rol" onsubmit="agregarRolAUsuario(); return false;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_agregar_rolLabel">Agregar rol al usuario {{ $user->name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div><!-- /.modal-header -->
        <div class="modal-body">
          <div class="form-group">
            <label for="rol_a_agregar" class="col-form-label">Rol a agregar</label>
            <select class="form-control" id="rol_a_agregar">
              <option value="0">Seleccionar</option>
              @foreach($roles as $rol)
                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
              @endforeach
            </select>
          </div><!-- /.form-group -->
          <div class="form-result"></div>
        </div><!-- /.modal-body -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary mx-auto">Agregar</button>
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal#modal_agregar_rol -->


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
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_agregar_rol"><i class="fa fa-plus"></i> Agregar</button>
          </div><!-- /.btn-group -->
          <img class="border rounded my-n3 ml-n3 mr-1" src="{{ asset('storage/avatars/'.$user->avatar) }}" style="width: 30px" /> 
          Roles del usuario {{ $user->name }}
        </div><!-- /.card-header -->

        <table class="table table-hover table-striped table-sm mb-0">
          <thead>
            <tr>
              <td>Nombre</td>
              <td>Descripción</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            @foreach($user->roles as $rol)
              <tr>
                <td class="align-middle">{{ $rol->name }}</td>
                <td class="align-middle">{{ $rol->description }}</td>
                <td style="width: 50px;">
                  <button type="button" class="btn btn-quitar_rol btn-outline-warning btn-sm btn-hover" title="Quitrar rol" data-toggle="tooltip" data-id="{{ $rol->id }}" data-name="{{ $rol->name }}"><i class="fa fa-remove"></i></button>
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
    $('button.btn-quitar_rol').click(function(){
      quitarRolAUsuario(this);
    });
  });

    function agregarRolAUsuario(){
      $.ajax({
  	    type: "POST",
  	    cache: false,
  	    url: '{{ route('roles.agregarRolAUsuario') }}',
        data: {
          userId: {{ $user->id }},
          rolId: $("#rol_a_agregar").val(),
        },
  	    beforeSend: function(){
          $("#form-agregar_rol .form-result").html('<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>');
  	    },
  	    error: function(xhr, status, error){
          $("#card-usuarios .overlay").hide();
          var err = JSON.parse(xhr.responseText);
          $("#form-agregar_rol .form-result").html('<div class="alert alert-warning">'+err.message+'</div>');
  	    },
  	    success: function(x){
  				x = $.trim(x);
  				if(x.substr(0,2) == "ok"){
            $("#form-agregar_rol .form-result").html('<div class="alert alert-success"><h4>Rol agregado</h4><div class="spinner-grow spinner-grow-sm" role="status"></div>Recargando...</div>');
            window.location.reload();
  	      }
  	      else{
            $("#form-agregar_rol .form-result").html('<div class="alert alert-warning">'+x+'</div>');
          }
  	    }// /success
  	  });// /ajax
    }// /agregarRolAUsuario


    function quitarRolAUsuario(target){
      if(! confirm('¿Seguro que deseas quitar el rol "'+$(target).data('name')+'" al usuario {{ $user->name }}?')){ return; }
      $.ajax({
  	    type: "DELETE",
  	    cache: false,
  	    url: '{{ route('roles.quitarRolAUsuario') }}',
        data: {
          userId: {{ $user->id }},
          rolId: $(target).data('id'),
        },
  	    beforeSend: function(){
          $("#card-roles .overlay").show();
  	    },
  	    error: function(xhr, status, error){
          $("#card-roles .overlay").hide();
          var err = JSON.parse(xhr.responseText);
          alert(err.message);
  	    },
  	    success: function(x){
  				x = $.trim(x);
          $("#card-roles .overlay").hide();
  				if(x.substr(0,2) == "ok"){
            window.location.reload();
  	      }
  	      else{
            alert(x);
          }
  	    }// /success
  	  });// /ajax
    }// /quitarRolAUsuario

  </script>
@endsection
