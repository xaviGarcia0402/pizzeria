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
              <option value="99">FICTICIO</option>
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
                  <a href="{{ route('roles.edit', ['role'=>$rol->id]) }}" class="btn btn-outline-warning btn-sm"><i class="fa fa-remove"></i></a>
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

  </script>
@endsection
