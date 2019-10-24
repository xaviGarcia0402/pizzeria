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
              <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('usuarios.inactivos') }}"><i class="fa fa-group" aria-hidden="true"></i> Ver desactivados</a>
              </div>
            @else
              <a href="{{ route('usuarios.index') }}" class="btn btn-primary float-right "><i class="fa fa-chevron-left"></i> Volver a activos</a>
            @endif
          </div><!-- /.btn-group -->
          Usuarios
        </div><!-- /.card-header -->

        <div class="card-body p-1">
          <table class="data-table table table-hover table-striped table-sm mb-0" style="width: 100%;">
            <thead>
              <tr>
                <td>Usuario</td>
                <td>Email</td>
                <td class="text-center">Roles</td>
                <td></td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div><!-- /.card-body -->

        <div class="overlay" style="display: none;"><i class="fa fa-2x fa-refresh fa-spin"></i></div>

      </div><!-- /.card -->

    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->
@endsection

@section('footer_scripts')
  <script type="text/javascript">

    window.addEventListener('load', function(){

      var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('usuarios.index', ["activos" => $activos]) }}",
        columns: [
          {data: 'name', name: 'name'},
          {data: 'email', name: 'email'},
          {data: 'roles', name: 'roles', orderable: false, searchable: false, "width": "80px", className: ""},
          {data: 'action', name: 'action', orderable: false, searchable: false, "width": "100px"},
        ],
        columnDefs: [
          { className: "align-middle", targets: "_all" }
        ],
      });// /DataTable

      $(document).on("click", "button.btn-status", function(e){
        statusToggle(this);
      });

    });// /window load

    function statusToggle(target){
      $('[data-toggle="tooltip"]').tooltip('hide');
      if(! confirm('¿Seguro que deseas {{ $activos ? 'desactivar' : 'restaurar' }} al usuario '+$(target).data('name')+'?')){ return; }
      $.ajax({
  	    type: "{{ $activos ? 'DELETE' : 'POST' }}",
  	    cache: false,
  	    url: '/admin/usuarios/' + $(target).data('id'),
  	    beforeSend: function(){
          $("#card-usuarios .overlay").show();
  	    },
  	    error: function(xhr, status, error){
          $("#card-usuarios .overlay").hide();
          var err = JSON.parse(xhr.responseText);
          alert(err.message);
  	    },
  	    success: function(x){
  				x = $.trim(x);
          $("#card-usuarios .overlay").hide();
  				if(x.substr(0,2) == "ok"){
            $('.data-table').DataTable().ajax.reload(null, false);
  	      }
  	      else{
            alert(x);
          }
  	    }// /success
  	  });// /ajax
    }// /statusToggle

  </script>
@endsection
