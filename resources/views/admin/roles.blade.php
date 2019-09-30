@extends('layouts.app')

@section('content')

<div class="modal fade" id="modal_usuarios" tabindex="-1" role="dialog" aria-labelledby="modal_usuariosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_usuariosLabel">Usuarios con el rol <strong><span></span></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!-- /.modal-header -->
      <div class="modal-body p-0">
        <div id="card-usuarios_rol" class="card">
          <div class="card-body p-0"></div>
          <div class="overlay" style="display: none;"><i class="fa fa-2x fa-refresh fa-spin"></i></div>
        </div><!-- /#card-usuarios_rol -->
      </div><!-- /.modal-body -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div><!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal#modal_usuarios -->


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
            <a href="{{ route('roles.create') }}" class="btn btn-primary float-right "><i class="fa fa-plus"></i> Nuevo</a>
          </div><!-- /.btn-group -->
          Roles
        </div><!-- /.card-header -->

        <table class="table table-hover table-striped table-sm mb-0">
          <thead>
            <tr>
              <td>Nombre</td>
              <td>Descripción</td>
              <td class="text-center" style="width: 80px;">Usuarios</td>
              <td style="width: 100px;"></td>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $rol)
              <tr>
                <td class="align-middle">{{ $rol->name }}</td>
                <td class="align-middle">{{ $rol->description }}</td>
                <td>
                  <button data-id="{{ $rol->id }}" data-name="{{ $rol->name }}" type="button" class="btn-usuarios btn btn-outline-secondary btn-sm btn-block border-0">
                    {{ $rol->users()->count() }}
                  </button>
                </td>
                <td class="text-right">
                  <a href="{{ route('roles.edit', ['role'=>$rol->id]) }}" class="btn btn-primary btn-sm btn-hover">Editar</a>
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
      $('button.btn-usuarios').click(function(){
        usuariosConRol(this);
      });
      $(document).on("click", ".btn-quitar_rol", function(){
        quitarRolAUsuario( $(this) );
      });
    });

    function usuariosConRol(target){
      $.ajax({
  	    type: "GET",
  	    cache: false,
  	    url: '/admin/roles/usuariosConRol/' + $(target).data('id'),
  	    beforeSend: function(){
          $("#modal_usuarios .modal-title span").html( $(target).data('name') );
          $("#modal_usuarios").modal();
          $("#card-usuarios_rol .overlay").show();
  	    },
  	    error: function(xhr, status, error){
          $("#card-usuarios_rol .overlay").hide();
          var err = JSON.parse(xhr.responseText);
          alert(err.message);
  	    },
  	    success: function(x){
          $("#card-usuarios_rol .card-body").html(x);
          $("#card-usuarios_rol .overlay").hide();
  	    }// /success
  	  });// /ajax
    }// /usuariosConRol


    function quitarRolAUsuario(target){
      if(! confirm('¿Seguro que deseas quitar el rol al usuario "'+$(target).data('name')+'"?')){ return; }
      $.ajax({
  	    type: "DELETE",
  	    cache: false,
  	    url: '{{ route('roles.quitarRolAUsuario') }}',
        data: {
          userId: $(target).data('userid'),
          rolId: $(target).data('rolid'),
        },
  	    beforeSend: function(){
          $("#card-usuarios_rol .overlay").show();
  	    },
  	    error: function(xhr, status, error){
          $("#card-usuarios_rol .overlay").hide();
          var err = JSON.parse(xhr.responseText);
          alert(err.message);
  	    },
  	    success: function(x){
  				x = $.trim(x);
  				if(x.substr(0,2) == "ok"){
            $("#card-usuarios_rol .overlay").hide();
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
